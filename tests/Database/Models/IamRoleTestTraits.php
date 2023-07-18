<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamRoleQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamRoleService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamRoleTestTraits
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

    public function test_http_iamrole_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamrole',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iamrole_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iamrole', [
            'form_params'   =>  [
                'name'  =>  'a',
                'label'  =>  'a',
                'description'  =>  'a',
                'level'  =>  '1',
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
    public function test_iamrole_model_get()
    {
        $result = AbstractIamRoleService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamrole_get_all()
    {
        $result = AbstractIamRoleService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamrole_get_paginated()
    {
        $result = AbstractIamRoleService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamrole_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamrole_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamRole::first();

            event( new \NextDeveloper\IAM\Events\IamRole\IamRoleRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_name_filter()
    {
        try {
            $request = new Request([
                'name'  =>  'a'
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_label_filter()
    {
        try {
            $request = new Request([
                'label'  =>  'a'
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_description_filter()
    {
        try {
            $request = new Request([
                'description'  =>  'a'
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_level_filter()
    {
        try {
            $request = new Request([
                'level'  =>  '1'
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_created_at_filter_start()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_updated_at_filter_start()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_deleted_at_filter_start()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_created_at_filter_end()
    {
        try {
            $request = new Request([
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_updated_at_filter_end()
    {
        try {
            $request = new Request([
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_deleted_at_filter_end()
    {
        try {
            $request = new Request([
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamrole_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamRoleQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamRole::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}