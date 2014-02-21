<?php

namespace App\Models;

use T4\Orm\Model;

class Block
    extends Model
{

    static protected $schema = [
        'columns' => [
            'section'   => ['type'=>'int'],
            'path'      => ['type'=>'string'],
            'params'    => ['type'=>'text'],
            'order'     => ['type'=>'int'],
        ],
    ];

}