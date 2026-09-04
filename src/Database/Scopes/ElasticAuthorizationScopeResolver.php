<?php

namespace NextDeveloper\IAM\Database\Scopes;

use Illuminate\Database\Eloquent\Model;
use NextDeveloper\IAM\Authorization\Roles\AnonymousRole;
use NextDeveloper\IAM\Authorization\Roles\RoleToElasticFilterInterface;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * The Elasticsearch-side counterpart of AuthorizationScope::apply() - reproduces its exact
 * role-selection algorithm (roles ordered by level ascending via UserHelper::getRoles(),
 * first role whose canBeApplied($table) is true wins, everything else the user holds is
 * ignored for this resolution) rather than approximating it, so ES tenant scoping matches
 * the DB path role-for-role.
 *
 * Unlike AuthorizationScope this does not replicate the per-table bypass list
 * (common_currencies/common_countries/iam_users) or the auth_bypass_uris check - those
 * decide whether a model gets scoped at all, which the caller (the ES-aware read path for
 * a specific model) has already decided by calling this resolver in the first place.
 */
class ElasticAuthorizationScopeResolver
{
    /**
     * @return array|null An ES filter clause to AND into the query, or null if the winning
     *                     role applies no restriction (full visibility for this model).
     */
    public function resolve(Model $modelInstance): ?array
    {
        $roles = UserHelper::getRoles();

        if (!$roles) {
            return $this->toElasticFilter(new AnonymousRole(), $modelInstance);
        }

        foreach ($roles as $role) {
            if (!$role->class || !class_exists($role->class)) {
                continue;
            }

            $roleInstance = app($role->class);

            if ($roleInstance->canBeApplied($modelInstance->getTable())) {
                return $this->toElasticFilter($roleInstance, $modelInstance);
            }
        }

        return $this->toElasticFilter(new AnonymousRole(), $modelInstance);
    }

    private function toElasticFilter($roleInstance, Model $modelInstance): ?array
    {
        if (!$roleInstance instanceof RoleToElasticFilterInterface) {
            throw new \RuntimeException(sprintf(
                '%s does not implement RoleToElasticFilterInterface - cannot resolve an '
                . 'Elasticsearch filter for %s. Every role reachable for a model that reads '
                . 'from Elasticsearch must implement toElasticFilter().',
                get_class($roleInstance),
                get_class($modelInstance)
            ));
        }

        return $roleInstance->toElasticFilter($modelInstance);
    }
}
