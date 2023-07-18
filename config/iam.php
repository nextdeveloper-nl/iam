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
            'weight'    =>  1,
            'AuthorizationModel' => '\NextDeveloper\IAM\Database\Abstract\AuthorizationModel::class'
        ],
        'system-admin'  =>  [
            'weight'    =>  100,
            'AuthorizationModel' => '\NextDeveloper\IAM\Database\Abstract\AuthorizationModel::class'
        ]
    ]
];