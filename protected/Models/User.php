<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Class User
 * @package App\Models
 */
class User
    extends Model
{
    public static $schema = [
        'table' => '__users',
        'columns' => [
            'email'     => ['type'=>'string'],
            'password'  => ['type'=>'string'],
            'first_name' => ['type' => 'string'],
            'name' => ['type' => 'string'],
            'father_name' => ['type' => 'string'],
            'organization' => ['type' => 'string'],
            'phone' => ['type' => 'string'],
        ],
        'relations' => [
            'role'=>['type'=>self::BELONGS_TO, 'model'=>\App\Models\Role::class],
            'statements'=>['type'=>self::HAS_MANY, 'model'=>\App\Models\Statement::class]
        ],
    ];

    public function hasRole($role)
    {
        return !empty($this->role) && ( ($role == $this->role->name) || ($role == $this->role->title) );
    }
}
