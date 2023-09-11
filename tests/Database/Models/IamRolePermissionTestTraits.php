<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamRolePermissionQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamRolePermissionService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamRolePermissionTestTraits
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

    public function test_http_iamrolepermission_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamrolepermission',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamrolepermission_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamrolepermission', [
            'form_params'   =>  [
                'created_by'  =>  '1',
                'updated_by'  =>  '1',
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
    public function test_iamrolepermission_model_get()
    {
        $result = AbstractIamRolePermissionService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamrolepermission_get_all()
    {
        $result = AbstractIamRolePermissionService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamrolepermission_get_paginated()
    {
        $result = AbstractIamRolePermissionService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamrolepermission_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrolepermission_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::first();

            event(new \NextDeveloper\IAM\Events\IamRolePermission\IamRolePermissionRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_created_by_filter()
    {
        try {
            $request = new Request(
                [
                'created_by'  =>  '1'
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_updated_by_filter()
    {
        try {
            $request = new Request(
                [
                'updated_by'  =>  '1'
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrolepermission_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamRolePermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRolePermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}