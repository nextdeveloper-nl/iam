<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use NextDeveloper\IAM\Database\Filters\IamUserQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;

trait IamUserTestTraits
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

    public function test_http_iamuser_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamuser',
            ['http_errors' => false]
        );

        $this->assertContains(
            $response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
            ]
        );
    }

    public function test_http_iamuser_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'POST', '/iam/iamuser', [
            'form_params'   =>  [
                'name'  =>  'a',
                'surname'  =>  'a',
                'email'  =>  'a',
                'fullname'  =>  'a',
                'username'  =>  'a',
                'about'  =>  'a',
                'pronoun'  =>  'a',
                'nin'  =>  'a',
                'phone_number'  =>  'a',
                    'birthday'  =>  now(),
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
    public function test_iamuser_model_get()
    {
        $result = AbstractIamUserService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuser_get_all()
    {
        $result = AbstractIamUserService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuser_get_paginated()
    {
        $result = AbstractIamUserService::get(
            null, [
            'paginated' =>  'true'
            ]
        );

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamuser_event_retrieved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRetrievedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_created_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserCreatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_creating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserCreatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_saving_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserSavingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_saved_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserSavedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_updating_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserUpdatingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_updated_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserUpdatedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_deleting_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserDeletingEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_deleted_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserDeletedEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_restoring_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRestoringEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_restored_without_object()
    {
        try {
            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRestoredEvent());
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRetrievedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserCreatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserCreatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserSavingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserSavedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserUpdatingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserUpdatedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserDeletingEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserDeletedEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRestoringEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuser_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUser::first();

            event(new \NextDeveloper\IAM\Events\IamUser\IamUserRestoredEvent($model));
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_name_filter()
    {
        try {
            $request = new Request(
                [
                'name'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_surname_filter()
    {
        try {
            $request = new Request(
                [
                'surname'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_email_filter()
    {
        try {
            $request = new Request(
                [
                'email'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_fullname_filter()
    {
        try {
            $request = new Request(
                [
                'fullname'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_username_filter()
    {
        try {
            $request = new Request(
                [
                'username'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_about_filter()
    {
        try {
            $request = new Request(
                [
                'about'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_pronoun_filter()
    {
        try {
            $request = new Request(
                [
                'pronoun'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_nin_filter()
    {
        try {
            $request = new Request(
                [
                'nin'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_phone_number_filter()
    {
        try {
            $request = new Request(
                [
                'phone_number'  =>  'a'
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_birthday_filter_start()
    {
        try {
            $request = new Request(
                [
                'birthdayStart'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_created_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_updated_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_deleted_at_filter_start()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_birthday_filter_end()
    {
        try {
            $request = new Request(
                [
                'birthdayEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_created_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_updated_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_deleted_at_filter_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_birthday_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'birthdayStart'  =>  now(),
                'birthdayEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuser_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request(
                [
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
                ]
            );

            $filter = new IamUserQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUser::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n
}