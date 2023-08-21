<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamAccountTypeQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamAccountTypeService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamAccountTypeTestTraits
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

    public function test_http_iamaccounttype_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamaccounttype',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iamaccounttype_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iamaccounttype', [
            'form_params'   =>  [
                'name'  =>  'a',
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
    public function test_iamaccounttype_model_get()
    {
        $result = AbstractIamAccountTypeService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccounttype_get_all()
    {
        $result = AbstractIamAccountTypeService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamaccounttype_get_paginated()
    {
        $result = AbstractIamAccountTypeService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamaccounttype_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccounttype_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamaccounttype_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::first();

            event( new \NextDeveloper\IAM\Events\IamAccountType\IamAccountTypeRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccounttype_event_name_filter()
    {
        try {
            $request = new Request([
                'name'  =>  'a'
            ]);

            $filter = new IamAccountTypeQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamaccounttype_event_description_filter()
    {
        try {
            $request = new Request([
                'description'  =>  'a'
            ]);

            $filter = new IamAccountTypeQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamAccountType::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}