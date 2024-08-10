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
    'anonymous_uris'    =>  [
    ],
    'configuration' =>  [
        'iam_accounts'  =>  [
            'can_change_domain' =>  false
        ],
        'autoadd_users_with_same_domain'    =>  false
    ],

    /**
     * This is the nin service configuration.
     * You can add more services to the 'nin' array.
     */
    'nin' => [
        'tr' => [
            'endpoints' => [
                'citizen' => env('TR_NIN_CITIZEN_ENDPOINT','https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL'),
                'foreign' => env('TR_NIN_FOREIGN_ENDPOINT','https://tckimlik.nvi.gov.tr/Service/KPSPublicYabanciDogrula.asmx?WSDL'),
            ],
            'class' => \NextDeveloper\IAM\Services\NinClients\TurkiyeNinService::class
        ],
    ],
];
