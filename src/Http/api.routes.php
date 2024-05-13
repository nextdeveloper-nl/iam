<?php

Route::prefix('iam')->group(
    function () {
        Route::prefix('accounts')->group(
            function () {
                Route::get('/', 'Accounts\AccountsController@index');
                Route::get('/actions', 'Accounts\AccountsController@getActions');

                Route::get('{iam_accounts}/tags ', 'Accounts\AccountsController@tags');
                Route::post('{iam_accounts}/tags ', 'Accounts\AccountsController@saveTags');
                Route::get('{iam_accounts}/addresses ', 'Accounts\AccountsController@addresses');
                Route::post('{iam_accounts}/addresses ', 'Accounts\AccountsController@saveAddresses');

                Route::get('/{iam_accounts}/{subObjects}', 'Accounts\AccountsController@relatedObjects');
                Route::get('/{iam_accounts}', 'Accounts\AccountsController@show');

                Route::post('/', 'Accounts\AccountsController@store');
                Route::post('/{iam_accounts}/do/{action}', 'Accounts\AccountsController@doAction');

                Route::patch('/{iam_accounts}', 'Accounts\AccountsController@update');
                Route::delete('/{iam_accounts}', 'Accounts\AccountsController@destroy');
            }
        );

        Route::prefix('users')->group(
            function () {
                Route::get('/', 'Users\UsersController@index');
                Route::get('/actions', 'Users\UsersController@getActions');

                Route::get('{iam_users}/tags ', 'Users\UsersController@tags');
                Route::post('{iam_users}/tags ', 'Users\UsersController@saveTags');
                Route::get('{iam_users}/addresses ', 'Users\UsersController@addresses');
                Route::post('{iam_users}/addresses ', 'Users\UsersController@saveAddresses');

                Route::get('/{iam_users}/{subObjects}', 'Users\UsersController@relatedObjects');
                Route::get('/{iam_users}', 'Users\UsersController@show');

                Route::post('/', 'Users\UsersController@store');
                Route::post('/{iam_users}/do/{action}', 'Users\UsersController@doAction');

                Route::patch('/{iam_users}', 'Users\UsersController@update');
                Route::delete('/{iam_users}', 'Users\UsersController@destroy');
            }
        );

        Route::prefix('login-logs')->group(
            function () {
                Route::get('/', 'LoginLogs\LoginLogsController@index');
                Route::get('/actions', 'LoginLogs\LoginLogsController@getActions');

                Route::get('{iam_login_logs}/tags ', 'LoginLogs\LoginLogsController@tags');
                Route::post('{iam_login_logs}/tags ', 'LoginLogs\LoginLogsController@saveTags');
                Route::get('{iam_login_logs}/addresses ', 'LoginLogs\LoginLogsController@addresses');
                Route::post('{iam_login_logs}/addresses ', 'LoginLogs\LoginLogsController@saveAddresses');

                Route::get('/{iam_login_logs}/{subObjects}', 'LoginLogs\LoginLogsController@relatedObjects');
                Route::get('/{iam_login_logs}', 'LoginLogs\LoginLogsController@show');

                Route::post('/', 'LoginLogs\LoginLogsController@store');
                Route::post('/{iam_login_logs}/do/{action}', 'LoginLogs\LoginLogsController@doAction');

                Route::patch('/{iam_login_logs}', 'LoginLogs\LoginLogsController@update');
                Route::delete('/{iam_login_logs}', 'LoginLogs\LoginLogsController@destroy');
            }
        );

        Route::prefix('account-types')->group(
            function () {
                Route::get('/', 'AccountTypes\AccountTypesController@index');
                Route::get('/actions', 'AccountTypes\AccountTypesController@getActions');

                Route::get('{iam_account_types}/tags ', 'AccountTypes\AccountTypesController@tags');
                Route::post('{iam_account_types}/tags ', 'AccountTypes\AccountTypesController@saveTags');
                Route::get('{iam_account_types}/addresses ', 'AccountTypes\AccountTypesController@addresses');
                Route::post('{iam_account_types}/addresses ', 'AccountTypes\AccountTypesController@saveAddresses');

                Route::get('/{iam_account_types}/{subObjects}', 'AccountTypes\AccountTypesController@relatedObjects');
                Route::get('/{iam_account_types}', 'AccountTypes\AccountTypesController@show');

                Route::post('/', 'AccountTypes\AccountTypesController@store');
                Route::post('/{iam_account_types}/do/{action}', 'AccountTypes\AccountTypesController@doAction');

                Route::patch('/{iam_account_types}', 'AccountTypes\AccountTypesController@update');
                Route::delete('/{iam_account_types}', 'AccountTypes\AccountTypesController@destroy');
            }
        );

        Route::prefix('account-user')->group(
            function () {
                Route::get('/', 'AccountUser\AccountUserController@index');
                Route::get('/actions', 'AccountUser\AccountUserController@getActions');

                Route::get('{iam_account_user}/tags ', 'AccountUser\AccountUserController@tags');
                Route::post('{iam_account_user}/tags ', 'AccountUser\AccountUserController@saveTags');
                Route::get('{iam_account_user}/addresses ', 'AccountUser\AccountUserController@addresses');
                Route::post('{iam_account_user}/addresses ', 'AccountUser\AccountUserController@saveAddresses');

                Route::get('/{iam_account_user}/{subObjects}', 'AccountUser\AccountUserController@relatedObjects');
                Route::get('/{iam_account_user}', 'AccountUser\AccountUserController@show');

                Route::post('/', 'AccountUser\AccountUserController@store');
                Route::post('/{iam_account_user}/do/{action}', 'AccountUser\AccountUserController@doAction');

                Route::patch('/{iam_account_user}', 'AccountUser\AccountUserController@update');
                Route::delete('/{iam_account_user}', 'AccountUser\AccountUserController@destroy');
            }
        );

        Route::prefix('backend-directories')->group(
            function () {
                Route::get('/', 'BackendDirectories\BackendDirectoriesController@index');
                Route::get('/actions', 'BackendDirectories\BackendDirectoriesController@getActions');

                Route::get('{iam_backend_directories}/tags ', 'BackendDirectories\BackendDirectoriesController@tags');
                Route::post('{iam_backend_directories}/tags ', 'BackendDirectories\BackendDirectoriesController@saveTags');
                Route::get('{iam_backend_directories}/addresses ', 'BackendDirectories\BackendDirectoriesController@addresses');
                Route::post('{iam_backend_directories}/addresses ', 'BackendDirectories\BackendDirectoriesController@saveAddresses');

                Route::get('/{iam_backend_directories}/{subObjects}', 'BackendDirectories\BackendDirectoriesController@relatedObjects');
                Route::get('/{iam_backend_directories}', 'BackendDirectories\BackendDirectoriesController@show');

                Route::post('/', 'BackendDirectories\BackendDirectoriesController@store');
                Route::post('/{iam_backend_directories}/do/{action}', 'BackendDirectories\BackendDirectoriesController@doAction');

                Route::patch('/{iam_backend_directories}', 'BackendDirectories\BackendDirectoriesController@update');
                Route::delete('/{iam_backend_directories}', 'BackendDirectories\BackendDirectoriesController@destroy');
            }
        );

        Route::prefix('permissions')->group(
            function () {
                Route::get('/', 'Permissions\PermissionsController@index');
                Route::get('/actions', 'Permissions\PermissionsController@getActions');

                Route::get('{iam_permissions}/tags ', 'Permissions\PermissionsController@tags');
                Route::post('{iam_permissions}/tags ', 'Permissions\PermissionsController@saveTags');
                Route::get('{iam_permissions}/addresses ', 'Permissions\PermissionsController@addresses');
                Route::post('{iam_permissions}/addresses ', 'Permissions\PermissionsController@saveAddresses');

                Route::get('/{iam_permissions}/{subObjects}', 'Permissions\PermissionsController@relatedObjects');
                Route::get('/{iam_permissions}', 'Permissions\PermissionsController@show');

                Route::post('/', 'Permissions\PermissionsController@store');
                Route::post('/{iam_permissions}/do/{action}', 'Permissions\PermissionsController@doAction');

                Route::patch('/{iam_permissions}', 'Permissions\PermissionsController@update');
                Route::delete('/{iam_permissions}', 'Permissions\PermissionsController@destroy');
            }
        );

        Route::prefix('login-mechanisms')->group(
            function () {
                Route::get('/', 'LoginMechanisms\LoginMechanismsController@index');
                Route::get('/actions', 'LoginMechanisms\LoginMechanismsController@getActions');

                Route::get('{iam_login_mechanisms}/tags ', 'LoginMechanisms\LoginMechanismsController@tags');
                Route::post('{iam_login_mechanisms}/tags ', 'LoginMechanisms\LoginMechanismsController@saveTags');
                Route::get('{iam_login_mechanisms}/addresses ', 'LoginMechanisms\LoginMechanismsController@addresses');
                Route::post('{iam_login_mechanisms}/addresses ', 'LoginMechanisms\LoginMechanismsController@saveAddresses');

                Route::get('/{iam_login_mechanisms}/{subObjects}', 'LoginMechanisms\LoginMechanismsController@relatedObjects');
                Route::get('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@show');

                Route::post('/', 'LoginMechanisms\LoginMechanismsController@store');
                Route::post('/{iam_login_mechanisms}/do/{action}', 'LoginMechanisms\LoginMechanismsController@doAction');

                Route::patch('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@update');
                Route::delete('/{iam_login_mechanisms}', 'LoginMechanisms\LoginMechanismsController@destroy');
            }
        );

        Route::prefix('role-user')->group(
            function () {
                Route::get('/', 'RoleUser\RoleUserController@index');
                Route::get('/actions', 'RoleUser\RoleUserController@getActions');

                Route::get('{iam_role_user}/tags ', 'RoleUser\RoleUserController@tags');
                Route::post('{iam_role_user}/tags ', 'RoleUser\RoleUserController@saveTags');
                Route::get('{iam_role_user}/addresses ', 'RoleUser\RoleUserController@addresses');
                Route::post('{iam_role_user}/addresses ', 'RoleUser\RoleUserController@saveAddresses');

                Route::get('/{iam_role_user}/{subObjects}', 'RoleUser\RoleUserController@relatedObjects');
                Route::get('/{iam_role_user}', 'RoleUser\RoleUserController@show');

                Route::post('/', 'RoleUser\RoleUserController@store');
                Route::post('/{iam_role_user}/do/{action}', 'RoleUser\RoleUserController@doAction');

                Route::patch('/{iam_role_user}', 'RoleUser\RoleUserController@update');
                Route::delete('/{iam_role_user}', 'RoleUser\RoleUserController@destroy');
            }
        );

        Route::prefix('roles')->group(
            function () {
                Route::get('/', 'Roles\RolesController@index');
                Route::get('/actions', 'Roles\RolesController@getActions');

                Route::get('{iam_roles}/tags ', 'Roles\RolesController@tags');
                Route::post('{iam_roles}/tags ', 'Roles\RolesController@saveTags');
                Route::get('{iam_roles}/addresses ', 'Roles\RolesController@addresses');
                Route::post('{iam_roles}/addresses ', 'Roles\RolesController@saveAddresses');

                Route::get('/{iam_roles}/{subObjects}', 'Roles\RolesController@relatedObjects');
                Route::get('/{iam_roles}', 'Roles\RolesController@show');

                Route::post('/', 'Roles\RolesController@store');
                Route::post('/{iam_roles}/do/{action}', 'Roles\RolesController@doAction');

                Route::patch('/{iam_roles}', 'Roles\RolesController@update');
                Route::delete('/{iam_roles}', 'Roles\RolesController@destroy');
            }
        );

        Route::prefix('role-permission')->group(
            function () {
                Route::get('/', 'RolePermission\RolePermissionController@index');
                Route::get('/actions', 'RolePermission\RolePermissionController@getActions');

                Route::get('{iam_role_permission}/tags ', 'RolePermission\RolePermissionController@tags');
                Route::post('{iam_role_permission}/tags ', 'RolePermission\RolePermissionController@saveTags');
                Route::get('{iam_role_permission}/addresses ', 'RolePermission\RolePermissionController@addresses');
                Route::post('{iam_role_permission}/addresses ', 'RolePermission\RolePermissionController@saveAddresses');

                Route::get('/{iam_role_permission}/{subObjects}', 'RolePermission\RolePermissionController@relatedObjects');
                Route::get('/{iam_role_permission}', 'RolePermission\RolePermissionController@show');

                Route::post('/', 'RolePermission\RolePermissionController@store');
                Route::post('/{iam_role_permission}/do/{action}', 'RolePermission\RolePermissionController@doAction');

                Route::patch('/{iam_role_permission}', 'RolePermission\RolePermissionController@update');
                Route::delete('/{iam_role_permission}', 'RolePermission\RolePermissionController@destroy');
            }
        );

        Route::prefix('user-roles')->group(
            function () {
                Route::get('/', 'UserRoles\UserRolesController@index');
                Route::get('/actions', 'UserRoles\UserRolesController@getActions');

                Route::get('{iam_user_roles}/tags ', 'UserRoles\UserRolesController@tags');
                Route::post('{iam_user_roles}/tags ', 'UserRoles\UserRolesController@saveTags');
                Route::get('{iam_user_roles}/addresses ', 'UserRoles\UserRolesController@addresses');
                Route::post('{iam_user_roles}/addresses ', 'UserRoles\UserRolesController@saveAddresses');

                Route::get('/{iam_user_roles}/{subObjects}', 'UserRoles\UserRolesController@relatedObjects');
                Route::get('/{iam_user_roles}', 'UserRoles\UserRolesController@show');

                Route::post('/', 'UserRoles\UserRolesController@store');
                Route::post('/{iam_user_roles}/do/{action}', 'UserRoles\UserRolesController@doAction');

                Route::patch('/{iam_user_roles}', 'UserRoles\UserRolesController@update');
                Route::delete('/{iam_user_roles}', 'UserRoles\UserRolesController@destroy');
            }
        );

        Route::prefix('user-accounts')->group(
            function () {
                Route::get('/', 'UserAccounts\UserAccountsController@index');
                Route::get('/actions', 'UserAccounts\UserAccountsController@getActions');

                Route::get('{iam_user_accounts}/tags ', 'UserAccounts\UserAccountsController@tags');
                Route::post('{iam_user_accounts}/tags ', 'UserAccounts\UserAccountsController@saveTags');
                Route::get('{iam_user_accounts}/addresses ', 'UserAccounts\UserAccountsController@addresses');
                Route::post('{iam_user_accounts}/addresses ', 'UserAccounts\UserAccountsController@saveAddresses');

                Route::get('/{iam_user_accounts}/{subObjects}', 'UserAccounts\UserAccountsController@relatedObjects');
                Route::get('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@show');

                Route::post('/', 'UserAccounts\UserAccountsController@store');
                Route::post('/{iam_user_accounts}/do/{action}', 'UserAccounts\UserAccountsController@doAction');

                Route::patch('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@update');
                Route::delete('/{iam_user_accounts}', 'UserAccounts\UserAccountsController@destroy');
            }
        );

        Route::prefix('account-user-perspective')->group(
            function () {
                Route::get('/', 'AccountUserPerspective\AccountUserPerspectiveController@index');
                Route::get('/actions', 'AccountUserPerspective\AccountUserPerspectiveController@getActions');

                Route::get('{iam_account_user_perspective}/tags ', 'AccountUserPerspective\AccountUserPerspectiveController@tags');
                Route::post('{iam_account_user_perspective}/tags ', 'AccountUserPerspective\AccountUserPerspectiveController@saveTags');
                Route::get('{iam_account_user_perspective}/addresses ', 'AccountUserPerspective\AccountUserPerspectiveController@addresses');
                Route::post('{iam_account_user_perspective}/addresses ', 'AccountUserPerspective\AccountUserPerspectiveController@saveAddresses');

                Route::get('/{iam_account_user_perspective}/{subObjects}', 'AccountUserPerspective\AccountUserPerspectiveController@relatedObjects');
                Route::get('/{iam_account_user_perspective}', 'AccountUserPerspective\AccountUserPerspectiveController@show');

                Route::post('/', 'AccountUserPerspective\AccountUserPerspectiveController@store');
                Route::post('/{iam_account_user_perspective}/do/{action}', 'AccountUserPerspective\AccountUserPerspectiveController@doAction');

                Route::patch('/{iam_account_user_perspective}', 'AccountUserPerspective\AccountUserPerspectiveController@update');
                Route::delete('/{iam_account_user_perspective}', 'AccountUserPerspective\AccountUserPerspectiveController@destroy');
            }
        );

        // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE





























        Route::prefix('my')->group(
            function () {
                Route::get('/roles', 'Roles\MyRolesController@index');
                Route::put('/roles', 'Roles\MyRolesController@update');

                Route::get('/accounts', 'Accounts\MyAccountsController@index');
                Route::put('/accounts', 'Accounts\MyAccountsController@update');

                Route::get('/profile', 'Users\MyUsersController@index');
                Route::put('/profile', 'Users\MyUsersController@update');
            }
        );
    }
);


