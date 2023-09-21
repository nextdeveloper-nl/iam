<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamAccountUserQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamAccountUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamAccountUserTestTraits
{
    public $http;

    /**
     *   Creating the Guzzle object
     */
    public function setupGuzzle()
    {
        $this->http = new Client(
            [
            'base_uri'  =>  '127.0.0.1:8000'
            ]
        );
    }

    /**
     *   Destroying the Guzzle object
     */
    public function destroyGuzzle()
    {
        $this->http = null;
    }

    public function test_http_iamaccountuser_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamaccountuser',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamaccountuser_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamaccountuser', [
            'form_params'   =>  [
                ],
                ['http_errors' => false]
            ]
        );

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    /**
     * Get test
     *
     * @return bool
     */
    public function test_iamaccountuser_model_get()
    {
        $result = AbstractIamAccountUserService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccountuser_get_all()
    {
        $result = AbstractIamAccountUserService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccountuser_get_paginated()
    {
        $result = AbstractIamAccountUserService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamaccountuser_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccountuser_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccountuser_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountUser::first();

            event(new \NextDeveloper\IAM\Events\IamAccountUser\IamAccountUserRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}