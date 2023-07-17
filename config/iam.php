<?php

return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],

    //  This is also the priority. So please make sure that the algorithm you want to use it on the top.
    'hash_algorithms' => [
        'argon2id',
        'scrypt',
        'bcrypt',
        'md5'
    ],

    //  WARNING: Do not edit here, since this configuration section is edited by the module
    'login_mechanisms'  =>  [

    ],

    //  WARNING: Do not edit here, since this configuration section is edited by the module
    'twofa_mechanisms'  =>  [

    ]
];