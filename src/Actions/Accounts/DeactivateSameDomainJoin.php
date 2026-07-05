<?php

namespace NextDeveloper\IAM\Actions\Accounts;

use NextDeveloper\Commons\Actions\AbstractAction;
use NextDeveloper\Commons\Common\Cache\CacheHelper;
use NextDeveloper\Commons\Exceptions\NotAllowedException;
use NextDeveloper\Events\Services\Events;
use NextDeveloper\IAM\Database\Models\Accounts;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Disables same-domain join for the account. Existing members are never removed;
 * the sync job becomes a no-op while the flag is off. Only the account owner may run this.
 */
class DeactivateSameDomainJoin extends AbstractAction
{
    public const EVENTS = [
        'same-domain-join-deactivated:NextDeveloper\IAM\Accounts',
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
        $this->setProgress(0, 'Disabling same-domain join');

        $this->model->updateQuietly([
            'allow_same_domain_join' => false,
        ]);

        CacheHelper::deleteKeys(get_class($this->model), $this->model->uuid);

        Events::fire('same-domain-join-deactivated:NextDeveloper\IAM\Accounts', $this->model->fresh());

        $this->setProgress(100, 'Same-domain join disabled');
    }
}
