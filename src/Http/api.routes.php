<?php

Route::prefix('iam')->group(function() {
Route::prefix('accounts')->group(function () {
        Route::get('/', 'IamAccount\IamAccountController@index');
        Route::get('/{iam-accounts}', 'IamAccount\IamAccountController@show');
        Route::post('/', 'IamAccount\IamAccountController@store');
        Route::put('/{iam-accounts}', 'IamAccount\IamAccountController@update');
        Route::delete('/{iam-accounts}', 'IamAccount\IamAccountController@destroy');
    });

Route::prefix('users')->group(function () {
        Route::get('/', 'IamUser\IamUserController@index');
        Route::get('/{iam-users}', 'IamUser\IamUserController@show');
        Route::post('/', 'IamUser\IamUserController@store');
        Route::put('/{iam-users}', 'IamUser\IamUserController@update');
        Route::delete('/{iam-users}', 'IamUser\IamUserController@destroy');
    });

Route::prefix('account-types')->group(function () {
        Route::get('/', 'IamAccountType\IamAccountTypeController@index');
        Route::get('/{iam-account-types}', 'IamAccountType\IamAccountTypeController@show');
        Route::post('/', 'IamAccountType\IamAccountTypeController@store');
        Route::put('/{iam-account-types}', 'IamAccountType\IamAccountTypeController@update');
        Route::delete('/{iam-account-types}', 'IamAccountType\IamAccountTypeController@destroy');
    });

Route::prefix('backend')->group(function () {
        Route::get('/', 'IamBackend\IamBackendController@index');
        Route::get('/{iam-backend}', 'IamBackend\IamBackendController@show');
        Route::post('/', 'IamBackend\IamBackendController@store');
        Route::put('/{iam-backend}', 'IamBackend\IamBackendController@update');
        Route::delete('/{iam-backend}', 'IamBackend\IamBackendController@destroy');
    });

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    Route::prefix('user')->group(function () {
        Route::get('/', 'User\UserController@index');
        Route::get('/{user}', 'User\UserController@show');
        Route::post('/', 'User\UserController@store');
        Route::put('/{user}', 'User\UserController@update');
        Route::delete('/{user}', 'User\UserController@destroy');
        Route::post('/oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
        Route::post('/login', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
        Route::post('/logout', '\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@destroy');
    });
});