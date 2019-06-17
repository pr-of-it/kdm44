<?php

namespace App\Models;

use App\Dto\UserUpdate\RequestDto;
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
            'middle_name' => ['type' => 'string'],
            'last_name' => ['type' => 'string'],
            'organization' => ['type' => 'string'],
            'phone' => ['type' => 'string'],
        ],
        'relations' => [
            'role'=>['type'=>self::BELONGS_TO, 'model'=>\App\Models\Role::class],
        ],
    ];

    public function hasRole($role)
    {
        return !empty($this->role) && ( ($role == $this->role->name) || ($role == $this->role->title) );
    }

    /**
     * @param RequestDto $data
     */
    public function setFieldsByRequest(RequestDto $data)
    {
        $this->password = password_hash($data->password, PASSWORD_DEFAULT);
    }
}
