<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamSshPublicKeyEventQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamSshPublicKeyEventService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamSshPublicKeyEventTestTraits
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

    public function test_http_iamsshpublickeyevent_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamsshpublickeyevent',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamsshpublickeyevent_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamsshpublickeyevent', [
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
    public function test_iamsshpublickeyevent_model_get()
    {
        $result = AbstractIamSshPublicKeyEventService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamsshpublickeyevent_get_all()
    {
        $result = AbstractIamSshPublicKeyEventService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamsshpublickeyevent_get_paginated()
    {
        $result = AbstractIamSshPublicKeyEventService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamsshpublickeyevent_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickeyevent_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKeyEvent\IamSshPublicKeyEventRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickeyevent_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyEventQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKeyEvent::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}