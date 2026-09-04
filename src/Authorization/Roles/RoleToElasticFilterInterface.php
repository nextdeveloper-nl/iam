<?php

namespace NextDeveloper\IAM\Authorization\Roles;

use Illuminate\Database\Eloquent\Model;

/**
 * Implemented by IAuthorizationRole classes alongside their existing apply(Builder, Model)
 * to provide the ES-query equivalent of that same tenant/row-visibility decision.
 *
 * Returns an ES filter clause array (merged into the query's bool.filter) restricting
 * results to what this role is allowed to see, or null if the role applies no restriction
 * at all for this model (the DB path's no-op apply() case - e.g. an admin role that can
 * see every tenant's rows for this table).
 */
interface RoleToElasticFilterInterface
{
    public function toElasticFilter(Model $modelInstance): ?array;
}
