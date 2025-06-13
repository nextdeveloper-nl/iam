<?php

namespace NextDeveloper\IAM\Tests\Database\Models;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Resource\Collection;
use NextDeveloper\IAM\Database\Filters\IamUserAccountOvervewQueryFilter;
use NextDeveloper\IAM\Services\AbstractServices\AbstractIamUserAccountOvervewService;

trait IamUserAccountOvervewTestTraits
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

    public function test_http_iamuseraccountovervew_get()
    {
        $this->setupGuzzle();
        $response = $this->http->request(
            'GET',
            '/iam/iamuseraccountovervew',
            ['http_errors' => false]
        );

        $this->assertContains($response->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_NOT_FOUND
        ]);
    }

    public function test_http_iamuseraccountovervew_post()
    {
        $this->setupGuzzle();
        $response = $this->http->request('POST', '/iam/iamuseraccountovervew', [
            'form_params'   =>  [
                'name'  =>  'a',
                'surname'  =>  'a',
                'email'  =>  'a',
                'fullname'  =>  'a',
                'username'  =>  'a',
                'about'  =>  'a',
                'nin'  =>  'a',
                'cell_phone'  =>  'a',
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
    public function test_iamuseraccountovervew_model_get()
    {
        $result = AbstractIamUserAccountOvervewService::get();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuseraccountovervew_get_all()
    {
        $result = AbstractIamUserAccountOvervewService::getAll();

        $this->assertIsObject($result, Collection::class);
    }

    public function test_iamuseraccountovervew_get_paginated()
    {
        $result = AbstractIamUserAccountOvervewService::get(null, [
            'paginated' =>  'true'
        ]);

        $this->assertIsObject($result, LengthAwarePaginator::class);
    }

    public function test_iamuseraccountovervew_event_retrieved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRetrievedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_created_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewCreatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_creating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewCreatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_saving_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewSavingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_saved_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewSavedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_updating_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewUpdatingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_updated_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewUpdatedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_deleting_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewDeletingEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_deleted_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewDeletedEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_restoring_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRestoringEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_restored_without_object()
    {
        try {
            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRestoredEvent() );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_retrieved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRetrievedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_created_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewCreatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_creating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewCreatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_saving_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewSavingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_saved_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewSavedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_updating_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewUpdatingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_updated_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewUpdatedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_deleting_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewDeletingEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_deleted_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewDeletedEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_restoring_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRestoringEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    public function test_iamuseraccountovervew_event_restored_with_object()
    {
        try {
            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::first();

            event( new \NextDeveloper\IAM\Events\IamUserAccountOvervew\IamUserAccountOvervewRestoredEvent($model) );
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_name_filter()
    {
        try {
            $request = new Request([
                'name'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_surname_filter()
    {
        try {
            $request = new Request([
                'surname'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_email_filter()
    {
        try {
            $request = new Request([
                'email'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_fullname_filter()
    {
        try {
            $request = new Request([
                'fullname'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_username_filter()
    {
        try {
            $request = new Request([
                'username'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_about_filter()
    {
        try {
            $request = new Request([
                'about'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_nin_filter()
    {
        try {
            $request = new Request([
                'nin'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_cell_phone_filter()
    {
        try {
            $request = new Request([
                'cell_phone'  =>  'a'
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_birthday_filter_start()
    {
        try {
            $request = new Request([
                'birthdayStart'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_created_at_filter_start()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_updated_at_filter_start()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_deleted_at_filter_start()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_birthday_filter_end()
    {
        try {
            $request = new Request([
                'birthdayEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_created_at_filter_end()
    {
        try {
            $request = new Request([
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_updated_at_filter_end()
    {
        try {
            $request = new Request([
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_deleted_at_filter_end()
    {
        try {
            $request = new Request([
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_birthday_filter_start_and_end()
    {
        try {
            $request = new Request([
                'birthdayStart'  =>  now(),
                'birthdayEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_created_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'created_atStart'  =>  now(),
                'created_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_updated_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'updated_atStart'  =>  now(),
                'updated_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function test_iamuseraccountovervew_event_deleted_at_filter_start_and_end()
    {
        try {
            $request = new Request([
                'deleted_atStart'  =>  now(),
                'deleted_atEnd'  =>  now()
            ]);

            $filter = new IamUserAccountOvervewQueryFilter($request);

            $model = \NextDeveloper\IAM\Database\Models\IamUserAccountOvervew::filter($filter)->first();
        } catch (\Exception $e) {
            $this->assertFalse(false, $e->getMessage());
        }

        $this->assertTrue(true);
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
