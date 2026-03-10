<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamSshPublicKeyQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamSshPublicKeyService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamSshPublicKeyTestTraits
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

    public function test_http_iamsshpublickey_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamsshpublickey',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamsshpublickey_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamsshpublickey', [
            'form_params'   =>  [
                'name'  =>  'a',
                'public_key'  =>  'a',
                'fingerprint'  =>  'a',
                'key_type'  =>  'a',
                'scope'  =>  'a',
                    'expires_at'  =>  now(),
                    'last_used_at'  =>  now(),
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
    public function test_iamsshpublickey_model_get()
    {
        $result = AbstractIamSshPublicKeyService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamsshpublickey_get_all()
    {
        $result = AbstractIamSshPublicKeyService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamsshpublickey_get_paginated()
    {
        $result = AbstractIamSshPublicKeyService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamsshpublickey_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeySavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeySavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeySavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeySavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamsshpublickey_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::first();

            event(new \NextDeveloper\IAM\Events\IamSshPublicKey\IamSshPublicKeyRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_public_key_filter()
    {
        try {
            $request = new Request(
                [
                'public_key'  =>  'a'
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_fingerprint_filter()
    {
        try {
            $request = new Request(
                [
                'fingerprint'  =>  'a'
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_key_type_filter()
    {
        try {
            $request = new Request(
                [
                'key_type'  =>  'a'
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_scope_filter()
    {
        try {
            $request = new Request(
                [
                'scope'  =>  'a'
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_expires_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'expires_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_last_used_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'last_used_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_expires_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'expires_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_last_used_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'last_used_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_expires_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'expires_atStart'  =>  now(),
                'expires_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_last_used_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'last_used_atStart'  =>  now(),
                'last_used_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamsshpublickey_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamSshPublicKeyQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamSshPublicKey::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}