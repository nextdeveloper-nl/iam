<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamAccountQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamAccountService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamAccountTestTraits
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

    public function test_http_iamaccount_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamaccount',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamaccount_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamaccount', [
            'form_params'   =>  [
                'name'  =>  'a',
                'phone_number'  =>  'a',
                'description'  =>  'a',
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
    public function test_iamaccount_model_get()
    {
        $result = AbstractIamAccountService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccount_get_all()
    {
        $result = AbstractIamAccountService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccount_get_paginated()
    {
        $result = AbstractIamAccountService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamaccount_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccount_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccount::first();

            event(new \NextDeveloper\IAM\Events\IamAccount\IamAccountRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_phone_number_filter()
    {
        try {
            $request = new Request(
                [
                'phone_number'  =>  'a'
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_description_filter()
    {
        try {
            $request = new Request(
                [
                'description'  =>  'a'
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccount_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamAccountQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccount::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}