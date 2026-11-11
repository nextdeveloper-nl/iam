<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\IAM\Database\Models\UserAccounts;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractUserAccountsTransformer;

/**
 * Class UserAccountsTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class UserAccountsTransformer extends AbstractUserAccountsTransformer {

    /**
     * Not cached: an iam_user_accounts row is one user's membership of an account, but its uuid is the
     * account's uuid. Caching by that uuid served one member's row (is_active, iam_user_id) to every other
     * member of the account, and nothing cleared it on an account switch, so the list kept showing the
     * old active account.
     *
     * @param UserAccounts $model
     *
     * @return array
     */
    public function transform(UserAccounts $model) {
        return parent::transform($model);
    }
}
