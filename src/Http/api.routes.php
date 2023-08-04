<?php

Route::prefix('iam')->group(function() {
Route::prefix('accounts')->group(function () {
        Route::get('/', 'IamAccount\IamAccountController@index');
        Route::get('/{iam_accounts}', 'IamAccount\IamAccountController@show');
        Route::post('/', 'IamAccount\IamAccountController@store');
        Route::put('/{iam_accounts}', 'IamAccount\IamAccountController@update');
        Route::delete('/{iam_accounts}', 'IamAccount\IamAccountController@destroy');
    });

Route::prefix('account-types')->group(function () {
        Route::get('/', 'IamAccountType\IamAccountTypeController@index');
        Route::get('/{iam_account-types}', 'IamAccountType\IamAccountTypeController@show');
        Route::post('/', 'IamAccountType\IamAccountTypeController@store');
        Route::put('/{iam_account-types}', 'IamAccountType\IamAccountTypeController@update');
        Route::delete('/{iam_account-types}', 'IamAccountType\IamAccountTypeController@destroy');
    });

Route::prefix('backends')->group(function () {
        Route::get('/', 'IamBackend\IamBackendController@index');
        Route::get('/{iam_backends}', 'IamBackend\IamBackendController@show');
        Route::post('/', 'IamBackend\IamBackendController@store');
        Route::put('/{iam_backends}', 'IamBackend\IamBackendController@update');
        Route::delete('/{iam_backends}', 'IamBackend\IamBackendController@destroy');
    });

Route::prefix('login-logs')->group(function () {
        Route::get('/', 'IamLoginLog\IamLoginLogController@index');
        Route::get('/{iam_login-logs}', 'IamLoginLog\IamLoginLogController@show');
        Route::post('/', 'IamLoginLog\IamLoginLogController@store');
        Route::put('/{iam_login-logs}', 'IamLoginLog\IamLoginLogController@update');
        Route::delete('/{iam_login-logs}', 'IamLoginLog\IamLoginLogController@destroy');
    });

Route::prefix('login-mechanisms')->group(function () {
        Route::get('/', 'IamLoginMechanism\IamLoginMechanismController@index');
        Route::get('/{iam_login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@show');
        Route::post('/', 'IamLoginMechanism\IamLoginMechanismController@store');
        Route::put('/{iam_login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@update');
        Route::delete('/{iam_login-mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@destroy');
    });

Route::prefix('permissions')->group(function () {
        Route::get('/', 'IamPermission\IamPermissionController@index');
        Route::get('/{iam_permissions}', 'IamPermission\IamPermissionController@show');
        Route::post('/', 'IamPermission\IamPermissionController@store');
        Route::put('/{iam_permissions}', 'IamPermission\IamPermissionController@update');
        Route::delete('/{iam_permissions}', 'IamPermission\IamPermissionController@destroy');
    });

Route::prefix('roles')->group(function () {
        Route::get('/', 'IamRole\IamRoleController@index');
        Route::get('/{iam_roles}', 'IamRole\IamRoleController@show');
        Route::post('/', 'IamRole\IamRoleController@store');
        Route::put('/{iam_roles}', 'IamRole\IamRoleController@update');
        Route::delete('/{iam_roles}', 'IamRole\IamRoleController@destroy');
    });

Route::prefix('role-user')->group(function () {
        Route::get('/', 'IamRoleUser\IamRoleUserController@index');
        Route::get('/{iam_role-user}', 'IamRoleUser\IamRoleUserController@show');
        Route::post('/', 'IamRoleUser\IamRoleUserController@store');
        Route::put('/{iam_role-user}', 'IamRoleUser\IamRoleUserController@update');
        Route::delete('/{iam_role-user}', 'IamRoleUser\IamRoleUserController@destroy');
    });

Route::prefix('users')->group(function () {
        Route::get('/', 'IamUser\IamUserController@index');
        Route::get('/{iam_users}', 'IamUser\IamUserController@show');
        Route::post('/', 'IamUser\IamUserController@store');
        Route::put('/{iam_users}', 'IamUser\IamUserController@update');
        Route::delete('/{iam_users}', 'IamUser\IamUserController@destroy');
    });

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE

    Route::prefix('authenticate')->group(function () {
        Route::post('/oauth/token', 'OAuth\AccessTokenController@issueToken');
        Route::post('/login', 'OAuth\AccessTokenController@issueToken');
    });
});