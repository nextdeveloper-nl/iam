<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamRoleUserQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamRoleUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamRoleUserTestTraits
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

    public function test_http_iamroleuser_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamroleuser',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamroleuser_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamroleuser', [
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
    public function test_iamroleuser_model_get()
    {
        $result = AbstractIamRoleUserService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamroleuser_get_all()
    {
        $result = AbstractIamRoleUserService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamroleuser_get_paginated()
    {
        $result = AbstractIamRoleUserService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamroleuser_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamroleuser_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamroleuser_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRoleUser::first();

            event(new \NextDeveloper\IAM\Events\IamRoleUser\IamRoleUserRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}