<?php

Route::prefix('iam')->group(function() {
Route::prefix('account-types')->group(function () {
        Route::get('/', 'IamAccountType\IamAccountTypeController@index');
        Route::get('/{iam_account_types}', 'IamAccountType\IamAccountTypeController@show');
        Route::post('/', 'IamAccountType\IamAccountTypeController@store');
        Route::patch('/{iam_account_types}', 'IamAccountType\IamAccountTypeController@update');
        Route::delete('/{iam_account_types}', 'IamAccountType\IamAccountTypeController@destroy');
    });

Route::prefix('account-user')->group(function () {
        Route::get('/', 'IamAccountUser\IamAccountUserController@index');
        Route::get('/{iam_account_user}', 'IamAccountUser\IamAccountUserController@show');
        Route::post('/', 'IamAccountUser\IamAccountUserController@store');
        Route::patch('/{iam_account_user}', 'IamAccountUser\IamAccountUserController@update');
        Route::delete('/{iam_account_user}', 'IamAccountUser\IamAccountUserController@destroy');
    });

Route::prefix('accounts')->group(function () {
        Route::get('/', 'IamAccount\IamAccountController@index');
        Route::get('/{iam_accounts}', 'IamAccount\IamAccountController@show');
        Route::post('/', 'IamAccount\IamAccountController@store');
        Route::patch('/{iam_accounts}', 'IamAccount\IamAccountController@update');
        Route::delete('/{iam_accounts}', 'IamAccount\IamAccountController@destroy');
    });

Route::prefix('backends')->group(function () {
        Route::get('/', 'IamBackend\IamBackendController@index');
        Route::get('/{iam_backends}', 'IamBackend\IamBackendController@show');
        Route::post('/', 'IamBackend\IamBackendController@store');
        Route::patch('/{iam_backends}', 'IamBackend\IamBackendController@update');
        Route::delete('/{iam_backends}', 'IamBackend\IamBackendController@destroy');
    });

Route::prefix('login-logs')->group(function () {
        Route::get('/', 'IamLoginLog\IamLoginLogController@index');
        Route::get('/{iam_login_logs}', 'IamLoginLog\IamLoginLogController@show');
        Route::post('/', 'IamLoginLog\IamLoginLogController@store');
        Route::patch('/{iam_login_logs}', 'IamLoginLog\IamLoginLogController@update');
        Route::delete('/{iam_login_logs}', 'IamLoginLog\IamLoginLogController@destroy');
    });

Route::prefix('login-mechanisms')->group(function () {
        Route::get('/', 'IamLoginMechanism\IamLoginMechanismController@index');
        Route::get('/{iam_login_mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@show');
        Route::post('/', 'IamLoginMechanism\IamLoginMechanismController@store');
        Route::patch('/{iam_login_mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@update');
        Route::delete('/{iam_login_mechanisms}', 'IamLoginMechanism\IamLoginMechanismController@destroy');
    });

Route::prefix('permissions')->group(function () {
        Route::get('/', 'IamPermission\IamPermissionController@index');
        Route::get('/{iam_permissions}', 'IamPermission\IamPermissionController@show');
        Route::post('/', 'IamPermission\IamPermissionController@store');
        Route::patch('/{iam_permissions}', 'IamPermission\IamPermissionController@update');
        Route::delete('/{iam_permissions}', 'IamPermission\IamPermissionController@destroy');
    });

Route::prefix('role-permission')->group(function () {
        Route::get('/', 'IamRolePermission\IamRolePermissionController@index');
        Route::get('/{iam_role_permission}', 'IamRolePermission\IamRolePermissionController@show');
        Route::post('/', 'IamRolePermission\IamRolePermissionController@store');
        Route::patch('/{iam_role_permission}', 'IamRolePermission\IamRolePermissionController@update');
        Route::delete('/{iam_role_permission}', 'IamRolePermission\IamRolePermissionController@destroy');
    });

Route::prefix('role-user')->group(function () {
        Route::get('/', 'IamRoleUser\IamRoleUserController@index');
        Route::get('/{iam_role_user}', 'IamRoleUser\IamRoleUserController@show');
        Route::post('/', 'IamRoleUser\IamRoleUserController@store');
        Route::patch('/{iam_role_user}', 'IamRoleUser\IamRoleUserController@update');
        Route::delete('/{iam_role_user}', 'IamRoleUser\IamRoleUserController@destroy');
    });

Route::prefix('roles')->group(function () {
        Route::get('/', 'IamRole\IamRoleController@index');
        Route::get('/{iam_roles}', 'IamRole\IamRoleController@show');
        Route::post('/', 'IamRole\IamRoleController@store');
        Route::patch('/{iam_roles}', 'IamRole\IamRoleController@update');
        Route::delete('/{iam_roles}', 'IamRole\IamRoleController@destroy');
    });

Route::prefix('users')->group(function () {
        Route::get('/', 'IamUser\IamUserController@index');
        Route::get('/{iam_users}', 'IamUser\IamUserController@show');
        Route::post('/', 'IamUser\IamUserController@store');
        Route::patch('/{iam_users}', 'IamUser\IamUserController@update');
        Route::delete('/{iam_users}', 'IamUser\IamUserController@destroy');
    });

Route::prefix('user-account-overview')->group(function () {
        Route::get('/', 'IamUserAccountOverview\IamUserAccountOverviewController@index');
        Route::get('/{iam_user_account_overview}', 'IamUserAccountOverview\IamUserAccountOverviewController@show');
        Route::post('/', 'IamUserAccountOverview\IamUserAccountOverviewController@store');
        Route::patch('/{iam_user_account_overview}', 'IamUserAccountOverview\IamUserAccountOverviewController@update');
        Route::delete('/{iam_user_account_overview}', 'IamUserAccountOverview\IamUserAccountOverviewController@destroy');
    });

Route::prefix('user-role-overview')->group(function () {
        Route::get('/', 'IamUserRoleOverview\IamUserRoleOverviewController@index');
        Route::get('/{iam_user_role_overview}', 'IamUserRoleOverview\IamUserRoleOverviewController@show');
        Route::post('/', 'IamUserRoleOverview\IamUserRoleOverviewController@store');
        Route::patch('/{iam_user_role_overview}', 'IamUserRoleOverview\IamUserRoleOverviewController@update');
        Route::delete('/{iam_user_role_overview}', 'IamUserRoleOverview\IamUserRoleOverviewController@destroy');
    });

Route::prefix('view-user-accounts')->group(function () {
        Route::get('/', 'IamViewUserAccount\IamViewUserAccountController@index');
        Route::get('/{iam_view_user_accounts}', 'IamViewUserAccount\IamViewUserAccountController@show');
        Route::post('/', 'IamViewUserAccount\IamViewUserAccountController@store');
        Route::patch('/{iam_view_user_accounts}', 'IamViewUserAccount\IamViewUserAccountController@update');
        Route::delete('/{iam_view_user_accounts}', 'IamViewUserAccount\IamViewUserAccountController@destroy');
    });

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

    Route::prefix('authenticate')->group(function () {
        Route::post('/oauth/token', 'OAuth\AccessTokenController@issueToken');
        Route::post('/login', 'OAuth\AccessTokenController@issueToken');
    });

    Route::prefix('my')->group(function() {
        Route::get('/roles', 'IamRole\IamMyRoleController@index');
        Route::put('/roles', 'IamRole\IamMyRoleController@update');

        Route::get('/accounts', 'IamAccount\IamMyAccountController@index');
    });
});