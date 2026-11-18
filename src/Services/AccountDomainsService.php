<?php

namespace NextDeveloper\IAM\Services;

use Illuminate\Support\Collection;
use NextDeveloper\Commons\Database\Models\Domains;
use NextDeveloper\Commons\Helpers\DomainsHelper;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Exceptions\UnauthorizedException;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Several domains per account (leo4#1255): `common_domains.iam_account_id` is the source of truth for "the domains
 * of this account"; `iam_accounts.common_domain_id` stays the PRIMARY domain. A domain belongs to one account only.
 * The account's domains are the union of the two, so existing single-domain accounts keep working unchanged
 * (their current domain is the primary one and needs no backfill).
 */
class AccountDomainsService
{
    /** Roles that may manage the domains of any account, besides its owners. */
    public const STAFF_ROLES = ['iam-admin', 'sales-admin', 'support-admin'];

    /**
     * Lower-cased host without scheme, "www." and path; null when nothing usable is left.
     */
    public static function normalize(?string $name): ?string
    {
        if ($name === null) {
            return null;
        }

        $domain = strtolower(trim($name));
        $domain = preg_replace('#^[a-z][a-z0-9+.-]*://#', '', $domain);
        $domain = preg_replace('#^www\.#', '', $domain);
        $domain = explode('/', $domain)[0];

        return $domain === '' ? null : $domain;
    }

    /**
     * All domains of the account, primary first.
     */
    public static function forAccount(Accounts $account): Collection
    {
        $domains = Domains::withoutGlobalScope(AuthorizationScope::class)
            ->where(function ($q) use ($account) {
                $q->where('iam_account_id', $account->id);

                if ($account->common_domain_id) {
                    $q->orWhere('id', $account->common_domain_id);
                }
            })
            ->orderBy('id')
            ->get();

        return $domains->sortBy(fn ($d) => $d->id == $account->common_domain_id ? 0 : 1)->values();
    }

    /**
     * Adds a domain to the account. Rejects a domain that belongs to another account. The first domain of an
     * account becomes its primary.
     *
     * @throws UnauthorizedException
     */
    public static function add(Accounts $account, string $name, bool $authorized = false): Domains
    {
        self::assertMayManage($account, $authorized);

        $normalized = self::normalize($name);

        if (! $normalized) {
            throw new UnauthorizedException('Invalid domain provided.');
        }

        if (! DomainsHelper::isFQDN($normalized) && ! DomainsHelper::allowNonFqdn()) {
            throw new UnauthorizedException('Domain is not a valid FQDN.');
        }

        // Both the canonical and the www variant, like the single-domain update, so there are no duplicates
        $domain = Domains::withoutGlobalScope(AuthorizationScope::class)
            ->whereIn('name', [$normalized, 'www.'.$normalized])
            ->first();

        if ($domain) {
            self::assertNotOwnedByAnotherAccount($domain, $account);

            if (! $domain->iam_account_id) {
                $domain->updateQuietly(['iam_account_id' => $account->id]);
            }
        } else {
            // fresh(): the uuid is a database default, so the created model does not carry it yet
            $domain = Domains::create(['name' => $normalized, 'iam_account_id' => $account->id, 'is_active' => true])->fresh();
        }

        if (! $account->common_domain_id) {
            self::applyPrimary($account, $domain);
        } elseif ($account->allow_same_domain_join) {
            // Users on the new domain can join right away
            Events::fire('same-domain-join-activated:NextDeveloper\IAM\Accounts', $account->fresh());
        }

        return $domain;
    }

    /**
     * Removes a secondary domain from the account (the domain row is kept, it only stops belonging to the
     * account). The primary domain can not be removed: make another one primary first.
     *
     * @throws UnauthorizedException
     */
    public static function remove(Accounts $account, string $domainUuid, bool $authorized = false): void
    {
        self::assertMayManage($account, $authorized);

        $domain = self::ownDomain($account, $domainUuid);

        if ($domain->id == $account->common_domain_id) {
            throw new UnauthorizedException('The primary domain can not be removed. Make another domain primary first.');
        }

        $domain->updateQuietly(['iam_account_id' => null]);
    }

    /**
     * Makes one of the account's domains the primary one.
     *
     * @throws UnauthorizedException
     */
    public static function setPrimary(Accounts $account, string $domainUuid, bool $authorized = false): Domains
    {
        self::assertMayManage($account, $authorized);

        $domain = self::ownDomain($account, $domainUuid);

        self::applyPrimary($account, $domain);

        return $domain;
    }

    /**
     * The account a domain name belongs to, via common_domains.iam_account_id (any domain of the account) or
     * iam_accounts.common_domain_id (primary). Null when the name belongs to nobody. Use this for every
     * "which company is this domain / email?" lookup.
     */
    public static function accountIdForDomainName(?string $name): ?int
    {
        $normalized = self::normalize($name);

        if (! $normalized) {
            return null;
        }

        $domain = Domains::withoutGlobalScope(AuthorizationScope::class)
            ->whereRaw('lower(name) in (?, ?)', [$normalized, 'www.'.$normalized])
            ->first();

        if (! $domain) {
            return null;
        }

        if ($domain->iam_account_id) {
            return (int) $domain->iam_account_id;
        }

        $accountId = Accounts::withoutGlobalScope(AuthorizationScope::class)->where('common_domain_id', $domain->id)->orderBy('id')->value('id');

        return $accountId ? (int) $accountId : null;
    }

    private static function applyPrimary(Accounts $account, Domains $domain): void
    {
        if ($account->common_domain_id != $domain->id) {
            $account->updateQuietly(['common_domain_id' => $domain->id]);
        }

        if ($account->allow_same_domain_join) {
            Events::fire('same-domain-join-activated:NextDeveloper\IAM\Accounts', $account->fresh());
        }
    }

    /**
     * @throws UnauthorizedException
     */
    private static function assertNotOwnedByAnotherAccount(Domains $domain, Accounts $account): void
    {
        if ($domain->iam_account_id && $domain->iam_account_id != $account->id) {
            throw new UnauthorizedException('This domain already belongs to another account.');
        }

        $claimedByOther = Accounts::withoutGlobalScope(AuthorizationScope::class)
            ->where('common_domain_id', $domain->id)
            ->where('id', '!=', $account->id)
            ->exists();

        if ($claimedByOther) {
            throw new UnauthorizedException('This domain already belongs to another account.');
        }
    }

    /**
     * @throws UnauthorizedException
     */
    private static function ownDomain(Accounts $account, string $domainUuid): Domains
    {
        $domain = self::forAccount($account)->firstWhere('uuid', $domainUuid);

        if (! $domain) {
            throw new UnauthorizedException('This domain does not belong to the account.');
        }

        return $domain;
    }

    /**
     * Owners (primary or co-owner) and staff. $authorized lets a caller that already checked its own rule, e.g. a
     * CRM account manager, pass.
     *
     * @throws UnauthorizedException
     */
    private static function assertMayManage(Accounts $account, bool $authorized): void
    {
        if ($authorized) {
            return;
        }

        $me = UserHelper::me();

        if ($me && UserHelper::isAccountOwner($me, $account)) {
            return;
        }

        foreach (self::STAFF_ROLES as $role) {
            if (UserHelper::hasRole($role)) {
                return;
            }
        }

        throw new UnauthorizedException('Only an owner of the account or staff can manage its domains.');
    }
}
