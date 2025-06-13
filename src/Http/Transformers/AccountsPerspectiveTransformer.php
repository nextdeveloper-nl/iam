<?php

namespace NextDeveloper\IAM\Http\Transformers;

use Illuminate\Support\Facades\Cache;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Database\Models\Countries;
use NextDeveloper\Commons\Database\Models\Domains;
use NextDeveloper\IAM\Database\Models\AccountsPerspective;
use NextDeveloper\IAM\Http\Transformers\AbstractTransformers\AbstractAccountsPerspectiveTransformer;

/**
 * Class AccountsPerspectiveTransformer. This class is being used to manipulate the data we are serving to the customer
 *
 * @package NextDeveloper\IAM\Http\Transformers
 */
class AccountsPerspectiveTransformer extends AbstractAccountsPerspectiveTransformer
{

    /**
     * @param AccountsPerspective $model
     *
     * @return array
     */
    public function transform(AccountsPerspective $model)
    {
        $transformed = Cache::get(
            CacheHelper::getKey('AccountsPerspective', $model->uuid, 'Transformed')
        );

        if($transformed) {
            return $transformed;
        }

        $transformed = parent::transform($model);

        //  I dont know why this id is coming as ID not UUID, but I fixed the problem here.
        if(intval($transformed['common_country_id']) === $transformed['common_country_id']) {
            $transformed['common_country_id'] = Countries::where('id', $transformed['common_country_id'])->first()->uuid;
        }

        //  I put this here just in case.
        if(intval($transformed['common_domain_id']) === $transformed['common_domain_id']) {
            $transformed['common_domain_id'] = Domains::where('id', $transformed['common_domain_id'])->first()->uuid;
        }

        Cache::set(
            CacheHelper::getKey('AccountsPerspective', $model->uuid, 'Transformed'),
            $transformed
        );

        return $transformed;
    }
}
