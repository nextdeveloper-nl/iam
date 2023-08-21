<?php

return [
    'hash_algorithms' => [
        'argon2id',
        'scrypt',
        'bcrypt',
        'md5'
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
            '\NextDeveloper\IAM\Database\Scopes\AuthorizationScope'
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