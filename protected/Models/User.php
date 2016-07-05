<?php

namespace App\Models;

use T4\Orm\Model;

class User
    extends Model
{
    public static $schema = [
        'table' => '__users',
        'columns' => [
            'email'     => ['type'=>'string'],
            'password'  => ['type'=>'string'],
        ],
        'relations' => [
            'role'=>['type'=>self::BELONGS_TO, 'model'=>\App\Models\Role::class]
        ],
    ];

    public function hasRole($role)
    {
        return !empty($this->role) && ( ($role == $this->role->name) || ($role == $this->role->title) );
    }

}