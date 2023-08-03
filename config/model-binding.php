<?php

return [
    'iamaccount' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamAccount::findByRef($value);
    },

'iamaccounttype' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamAccountType::findByRef($value);
    },

'iambackend' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamBackend::findByRef($value);
    },

'iamloginlog' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamLoginLog::findByRef($value);
    },

'iamloginmechanism' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamLoginMechanism::findByRef($value);
    },

'iampermission' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamPermission::findByRef($value);
    },

'iamrole' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamRole::findByRef($value);
    },

'iamuser' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamUser::findByRef($value);
    },

'iamaccount' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamAccount::findByRef($value);
    },

'iamaccounttype' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamAccountType::findByRef($value);
    },

'iambackend' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamBackend::findByRef($value);
    },

'iamloginlog' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamLoginLog::findByRef($value);
    },

'iamloginmechanism' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamLoginMechanism::findByRef($value);
    },

'iampermission' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamPermission::findByRef($value);
    },

'iamrole' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamRole::findByRef($value);
    },

'iamroleuser' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamRoleUser::findByRef($value);
    },

'iamuser' => function ($value) {
        return NextDeveloper\IAM\Database\Models\IamUser::findByRef($value);
    },

// EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
];