<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamBackendQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamBackendService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamBackendTestTraits
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

    public function test_http_iambackend_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iambackend',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iambackend_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iambackend', [
            'form_params'   =>  [
                'name'  =>  'a',
                'ldap_server_name'  =>  'a',
                'ldap_server_url'  =>  'a',
                'ldap_server_port'  =>  'a',
                'ldap_base_dn'  =>  'a',
                'ldap_bind_username'  =>  'a',
                'ldap_bind_password'  =>  'a',
                'default_filter'  =>  'a',
                'default_memberof'  =>  'a',
                'default_group'  =>  'a',
                'default_userid_field'  =>  'a',
                'default_password_field'  =>  'a',
                'default_email_field'  =>  'a',
                'default_alias_field'  =>  'a',
                'default_first_name_field'  =>  'a',
                'default_last_name_field'  =>  'a',
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
    public function test_iambackend_model_get()
    {
        $result = AbstractIamBackendService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iambackend_get_all()
    {
        $result = AbstractIamBackendService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iambackend_get_paginated()
    {
        $result = AbstractIamBackendService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iambackend_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iambackend_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamBackend::first();

            event(new \NextDeveloper\IAM\Events\IamBackend\IamBackendRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_server_name_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_server_name'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_server_url_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_server_url'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_server_port_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_server_port'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_base_dn_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_base_dn'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_bind_username_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_bind_username'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_ldap_bind_password_filter()
    {
        try {
            $request = new Request(
                [
                'ldap_bind_password'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_filter_filter()
    {
        try {
            $request = new Request(
                [
                'default_filter'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_memberof_filter()
    {
        try {
            $request = new Request(
                [
                'default_memberof'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_group_filter()
    {
        try {
            $request = new Request(
                [
                'default_group'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_userid_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_userid_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_password_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_password_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_email_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_email_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_alias_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_alias_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_first_name_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_first_name_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_default_last_name_field_filter()
    {
        try {
            $request = new Request(
                [
                'default_last_name_field'  =>  'a'
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iambackend_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamBackendQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamBackend::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}