<?php

namespace NextDeveloper\IAM\Actions\Accounts;

use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Exceptions\NotAllowedException;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Enables same-domain join for the account and attaches matching-domain users.
 * Only the account owner is allowed to run this action.
 */
class ActivateSameDomainJoin extends AbstractAction
{
    public const EVENTS = [
        'same-domain-join-activated:NextDeveloper\IAM\Accounts',
    ];

    /**
     * @throws NotAllowedException
     */
    public function __construct(Accounts $accounts, $params = null)
    {
        $this->model = $accounts;

        if ($accounts->iam_user_id !== UserHelper::me()?->id) {
            throw new NotAllowedException('Only the account owner can change domain-join settings.');
        }

        parent::__construct($params);
    }

    public function handle(): void
    {
        $this->setProgress(0, 'Enabling same-domain join');

        $this->model->updateQuietly([
            'allow_same_domain_join' => true,
        ]);

        CacheHelper::deleteKeys(get_class($this->model), $this->model->uuid);

        Events::fire('same-domain-join-activated:NextDeveloper\IAM\Accounts', $this->model->fresh());

        $this->setProgress(100, 'Same-domain join enabled');
    }
}
