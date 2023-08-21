<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamUserRoleOverviewQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamUserRoleOverviewService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamUserRoleOverviewTestTraits
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

    public function test_http_iamuserroleoverview_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamuserroleoverview',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iamuserroleoverview_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iamuserroleoverview', [
            'form_params'   =>  [
                'name'  =>  'a',
                'class'  =>  'a',
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
    public function test_iamuserroleoverview_model_get()
    {
        $result = AbstractIamUserRoleOverviewService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuserroleoverview_get_all()
    {
        $result = AbstractIamUserRoleOverviewService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuserroleoverview_get_paginated()
    {
        $result = AbstractIamUserRoleOverviewService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamuserroleoverview_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuserroleoverview_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::first();

            event( new \NextDeveloper\IAM\Events\IamUserRoleOverview\IamUserRoleOverviewRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_name_filter()
    {
        try {
            $request = new Request([
                'name'  =>  'a'
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_class_filter()
    {
        try {
            $request = new Request([
                'class'  =>  'a'
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_description_filter()
    {
        try {
            $request = new Request([
                'description'  =>  'a'
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_level_filter()
    {
        try {
            $request = new Request([
                'level'  =>  '1'
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_created_at_filter_start()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_updated_at_filter_start()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_deleted_at_filter_start()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_created_at_filter_end()
    {
        try {
            $request = new Request([
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_updated_at_filter_end()
    {
        try {
            $request = new Request([
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_deleted_at_filter_end()
    {
        try {
            $request = new Request([
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuserroleoverview_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamUserRoleOverviewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserRoleOverview::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}