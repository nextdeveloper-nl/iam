<?php

Route::prefix('iam')->group(function() {
Route::prefix('account-types')->group(function () {
        Route::get('/', 'AccountTypes\AccountTypesController@index');
        Route::get('/{iam_account_types}', 'AccountTypes\AccountTypesController@show');
        Route::post('/', 'AccountTypes\AccountTypesController@store');
        Route::patch('/{iam_account_types}', 'AccountTypes\AccountTypesController@update');
        Route::delete('/{iam_account_types}', 'AccountTypes\AccountTypesController@destroy');
    });

Route::prefix('account-user')->group(function () {
        Route::get('/', 'AccountUser\AccountUserController@index');
        Route::get('/{iam_account_user}', 'AccountUser\AccountUserController@show');
        Route::post('/', 'AccountUser\AccountUserController@store');
        Route::patch('/{iam_account_user}', 'AccountUser\AccountUserController@update');
        Route::delete('/{iam_account_user}', 'AccountUser\AccountUserController@destroy');
    });

Route::prefix('accounts')->group(function () {
        Route::get('/', 'Accounts\AccountsController@index');
        Route::get('/{iam_accounts}', 'Accounts\AccountsController@show');
        Route::post('/', 'Accounts\AccountsController@store');
        Route::patch('/{iam_accounts}', 'Accounts\AccountsController@update');
        Route::delete('/{iam_accounts}', 'Accounts\AccountsController@destroy');
    });

Route::prefix('backends')->group(function () {
        Route::get('/', 'Backends\BackendsController@index');
        Route::get('/{iam_backends}', 'Backends\BackendsController@show');
        Route::post('/', 'Backends\BackendsController@store');
        Route::patch('/{iam_backends}', 'Backends\BackendsController@update');
        Route::delete('/{iam_backends}', 'Backends\BackendsController@destroy');
    });

Route::prefix('login-logs')->group(function () {
        Route::get('/', 'LoginLogs\LoginLogsController@index');
        Route::get('/{iam_login_logs}', 'LoginLogs\LoginLogsController@show');
        Route::post('/', 'LoginLogs\LoginLogsController@store');
        Route::patch('/{iam_login_logs}', 'LoginLogs\LoginLogsController@update');
        Route::delete('/{iam_login_logs}', 'LoginLogs\LoginLogsController@destroy');
    });

Route::prefix('login-mechanisms')->group(function () {
        Route::get('/', 'LoginMechanisms\LoginMechanismsController@index');
        Route::get('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@show');
        Route::post('/', 'LoginMechanisms\LoginMechanismsController@store');
        Route::patch('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@update');
        Route::delete('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@destroy');
    });

Route::prefix('permissions')->group(function () {
        Route::get('/', 'Permissions\PermissionsController@index');
        Route::get('/{iam_permissions}', 'Permissions\PermissionsController@show');
        Route::post('/', 'Permissions\PermissionsController@store');
        Route::patch('/{iam_permissions}', 'Permissions\PermissionsController@update');
        Route::delete('/{iam_permissions}', 'Permissions\PermissionsController@destroy');
    });

Route::prefix('role-permission')->group(function () {
        Route::get('/', 'RolePermission\RolePermissionController@index');
        Route::get('/{iam_role_permission}', 'RolePermission\RolePermissionController@show');
        Route::post('/', 'RolePermission\RolePermissionController@store');
        Route::patch('/{iam_role_permission}', 'RolePermission\RolePermissionController@update');
        Route::delete('/{iam_role_permission}', 'RolePermission\RolePermissionController@destroy');
    });

Route::prefix('role-user')->group(function () {
        Route::get('/', 'RoleUser\RoleUserController@index');
        Route::get('/{iam_role_user}', 'RoleUser\RoleUserController@show');
        Route::post('/', 'RoleUser\RoleUserController@store');
        Route::patch('/{iam_role_user}', 'RoleUser\RoleUserController@update');
        Route::delete('/{iam_role_user}', 'RoleUser\RoleUserController@destroy');
    });

Route::prefix('roles')->group(function () {
        Route::get('/', 'Roles\RolesController@index');
        Route::get('/{iam_roles}', 'Roles\RolesController@show');
        Route::post('/', 'Roles\RolesController@store');
        Route::patch('/{iam_roles}', 'Roles\RolesController@update');
        Route::delete('/{iam_roles}', 'Roles\RolesController@destroy');
    });

Route::prefix('users')->group(function () {
        Route::get('/', 'Users\UsersController@index');
        Route::get('/{iam_users}', 'Users\UsersController@show');
        Route::post('/', 'Users\UsersController@store');
        Route::patch('/{iam_users}', 'Users\UsersController@update');
        Route::delete('/{iam_users}', 'Users\UsersController@destroy');
    });

Route::prefix('user-accounts')->group(function () {
        Route::get('/', 'UserAccounts\UserAccountsController@index');
        Route::get('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@show');
        Route::post('/', 'UserAccounts\UserAccountsController@store');
        Route::patch('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@update');
        Route::delete('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@destroy');
    });

Route::prefix('user-roles')->group(function () {
        Route::get('/', 'UserRoles\UserRolesController@index');
        Route::get('/{iam_user_roles}', 'UserRoles\UserRolesController@show');
        Route::post('/', 'UserRoles\UserRolesController@store');
        Route::patch('/{iam_user_roles}', 'UserRoles\UserRolesController@update');
        Route::delete('/{iam_user_roles}', 'UserRoles\UserRolesController@destroy');
    });

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n

    Route::prefix('authenticate')->group(function () {
        Route::post('/oauth/token', 'OAuth\AccessTokenController@issueToken');
        Route::post('/login', 'OAuth\AccessTokenController@issueToken');
    });

    Route::prefix('my')->group(function() {
        Route::get('/roles', 'Roles\MyRolesController@index');
        Route::put('/roles', 'Roles\MyRolesController@update');

        Route::get('/accounts', 'Accounts\MyAccountsController@index');
        Route::put('/accounts', 'Accounts\MyAccountsController@update');

        Route::get('/contact', 'Users\MyUsersController@index');
        Route::put('/contact', 'Users\MyUsersController@update');
    });
});