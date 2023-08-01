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
    ]
];