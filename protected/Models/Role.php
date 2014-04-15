<?php

namespace App\Models;

use T4\Orm\Model;

class Role
    extends Model
{
    public static $schema = [
        'columns' => [
            'name'     => ['type'=>'string'],
            'title'  => ['type'=>'string'],
        ],
        'relations' => [
            'users'=>[
                'type'=>self::HAS_MANY,
                'model'=>'User'
            ]
        ],
    ];

}