<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamPermissionQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamPermissionService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamPermissionTestTraits
{
    public $http;

    /**
    *   Creating the Guzzle object
    */
    public function setupGuzzle()
    {
        $this->http = new Client([
            'base_uri'  =>  '127.0.0.1:8000'
        ]);
    }

    /**
    *   Destroying the Guzzle object
    */
    public function destroyGuzzle()
    {
        $this->http = null;
    }

    public function test_http_iampermission_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iampermission',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iampermission_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iampermission', [
            'form_params'   =>  [
                'namespace'  =>  'a',
                'service'  =>  'a',
                'method'  =>  'a',
                'name'  =>  'a',
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
    public function test_iampermission_model_get()
    {
        $result = AbstractIamPermissionService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iampermission_get_all()
    {
        $result = AbstractIamPermissionService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iampermission_get_paginated()
    {
        $result = AbstractIamPermissionService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iampermission_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iampermission_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamPermission::first();

            event( new \NextDeveloper\IAM\Events\IamPermission\IamPermissionRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_namespace_filter()
    {
        try {
            $request = new Request([
                'namespace'  =>  'a'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_service_filter()
    {
        try {
            $request = new Request([
                'service'  =>  'a'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_method_filter()
    {
        try {
            $request = new Request([
                'method'  =>  'a'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_name_filter()
    {
        try {
            $request = new Request([
                'name'  =>  'a'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_created_by_filter()
    {
        try {
            $request = new Request([
                'created_by'  =>  '1'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_updated_by_filter()
    {
        try {
            $request = new Request([
                'updated_by'  =>  '1'
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_created_at_filter_start()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_updated_at_filter_start()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_created_at_filter_end()
    {
        try {
            $request = new Request([
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_updated_at_filter_end()
    {
        try {
            $request = new Request([
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iampermission_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamPermissionQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamPermission::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}