<?php

namespace NextDeveloper\IAM\Authorization\Roles;

/**
 * Co-owner marker role (#1305). A user holding this role in an account is treated as an owner of that account
 * (see UserHelper::isAccountOwner()). Data access is exactly that of a member, so it never widens what the
 * authorization scope returns; the privilege lives in the owner checks, not in this role's row filter.
 */
class AccountOwnerRole extends MemberRole
{
    public const NAME = 'account-owner';

    public const LEVEL = 254;

    public const DESCRIPTION = 'Co-owner of the account';

    public const DB_PREFIX = '*';
}
