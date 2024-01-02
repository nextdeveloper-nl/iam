<?php

return [
    'hash_algorithms' => [
        PASSWORD_ARGON2ID,
        PASSWORD_ARGON2I,
        PASSWORD_BCRYPT,
        PASSWORD_DEFAULT
    ],
    'roles' =>  [
        'member'    =>  [
            'AuthorizationModel' => '\NextDeveloper\IAM\Database\Abstract\AuthorizationModel::class'
        ],
        'system-admin'  =>  [
            'AuthorizationModel' => '\NextDeveloper\IAM\Database\Abstract\AuthorizationModel::class'
        ]
    ],
    'scopes'    =>  [
        'global' => [
            //  Dont do this here because it makes infinite loop with user object.
            '\NextDeveloper\IAM\Database\Scopes\AuthorizationScope',
            '\NextDeveloper\Commons\Database\GlobalScopes\LimitScope',
        ],
        'iam_accounts' => [
            //'\NextDeveloper\IAM\Database\Scopes\AuthorizationScope'
        ]
    ],
    //  These are the URI's to be bypassed without asking for any Authorization Scope
    'auth_bypass_uris'  =>  [
        '/iam/authenticate/oauth/token'
    ],
    ''
];
