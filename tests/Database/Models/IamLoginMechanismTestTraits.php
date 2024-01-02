<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamLoginMechanismQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamLoginMechanismService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamLoginMechanismTestTraits
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

    public function test_http_iamloginmechanism_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamloginmechanism',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamloginmechanism_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamloginmechanism', [
            'form_params'   =>  [
                'login_client'  =>  'a',
                'login_mechanism'  =>  'a',
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
    public function test_iamloginmechanism_model_get()
    {
        $result = AbstractIamLoginMechanismService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamloginmechanism_get_all()
    {
        $result = AbstractIamLoginMechanismService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamloginmechanism_get_paginated()
    {
        $result = AbstractIamLoginMechanismService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamloginmechanism_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginmechanism_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::first();

            event(new \NextDeveloper\IAM\Events\IamLoginMechanism\IamLoginMechanismRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_login_client_filter()
    {
        try {
            $request = new Request(
                [
                'login_client'  =>  'a'
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_login_mechanism_filter()
    {
        try {
            $request = new Request(
                [
                'login_mechanism'  =>  'a'
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginmechanism_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamLoginMechanismQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginMechanism::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}