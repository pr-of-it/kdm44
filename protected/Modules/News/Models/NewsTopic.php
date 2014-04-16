<?php

namespace App\Modules\News\Models;

use T4\Orm\Model;

class NewsTopic
    extends Model
{
    static protected $schema = [
        'columns' => [
            'title' => ['type'=>'string'],
        ]
    ];

    static protected $extension = ['tree'];

} 