<?php

Route::prefix('iam')->group(function() {
Route::prefix('accounts')->group(function () {
        Route::get('/', 'IamAccount\IamAccountController@index');
        Route::get('/{iam-accounts}', 'IamAccount\IamAccountController@show');
        Route::post('/', 'IamAccount\IamAccountController@store');
        Route::put('/{iam-accounts}', 'IamAccount\IamAccountController@update');
        Route::delete('/{iam-accounts}', 'IamAccount\IamAccountController@destroy');
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

Route::prefix('login-logs')->group(function () {
        Route::get('/', 'IamLoginLog\IamLoginLogController@index');
        Route::get('/{iam-login-logs}', 'IamLoginLog\IamLoginLogController@show');
        Route::post('/', 'IamLoginLog\IamLoginLogController@store');
        Route::put('/{iam-login-logs}', 'IamLoginLog\IamLoginLogController@update');
        Route::delete('/{iam-login-logs}', 'IamLoginLog\IamLoginLogController@destroy');
    });

Route::prefix('login-mechanisms')->group(function () {
        Route::get('/', 'IamLoginMechanism\IamLoginMechanismController@index');
        Route::get('/{iam-login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@show');
        Route::post('/', 'IamLoginMechanism\IamLoginMechanismController@store');
        Route::put('/{iam-login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@update');
        Route::delete('/{iam-login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@destroy');
    });

Route::prefix('permissions')->group(function () {
        Route::get('/', 'IamPermission\IamPermissionController@index');
        Route::get('/{iam-permissions}', 'IamPermission\IamPermissionController@show');
        Route::post('/', 'IamPermission\IamPermissionController@store');
        Route::put('/{iam-permissions}', 'IamPermission\IamPermissionController@update');
        Route::delete('/{iam-permissions}', 'IamPermission\IamPermissionController@destroy');
    });

Route::prefix('roles')->group(function () {
        Route::get('/', 'IamRole\IamRoleController@index');
        Route::get('/{iam-roles}', 'IamRole\IamRoleController@show');
        Route::post('/', 'IamRole\IamRoleController@store');
        Route::put('/{iam-roles}', 'IamRole\IamRoleController@update');
        Route::delete('/{iam-roles}', 'IamRole\IamRoleController@destroy');
    });

Route::prefix('users')->group(function () {
        Route::get('/', 'IamUser\IamUserController@index');
        Route::get('/{iam-users}', 'IamUser\IamUserController@show');
        Route::post('/', 'IamUser\IamUserController@store');
        Route::put('/{iam-users}', 'IamUser\IamUserController@update');
        Route::delete('/{iam-users}', 'IamUser\IamUserController@destroy');
    });

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    Route::prefix('authenticate')->group(function () {
        Route::post('/oauth/token', 'OAuth\AccessTokenController@issueToken');
        Route::post('/login', 'OAuth\AccessTokenController@issueToken');
    });
});