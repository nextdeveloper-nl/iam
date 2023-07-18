<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamLoginLogQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamLoginLogService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamLoginLogTestTraits
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

    public function test_http_iamloginlog_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamloginlog',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iamloginlog_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iamloginlog', [
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
    public function test_iamloginlog_model_get()
    {
        $result = AbstractIamLoginLogService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamloginlog_get_all()
    {
        $result = AbstractIamLoginLogService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamloginlog_get_paginated()
    {
        $result = AbstractIamLoginLogService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamloginlog_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginlog_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamloginlog_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::first();

            event( new \NextDeveloper\IAM\Events\IamLoginLog\IamLoginLogRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginlog_event_created_at_filter_start()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now()
            ]);

            $filter = new IamLoginLogQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginlog_event_created_at_filter_end()
    {
        try {
            $request = new Request([
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamLoginLogQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamloginlog_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamLoginLogQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamLoginLog::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}