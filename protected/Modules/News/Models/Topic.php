<?php

namespace App\Modules\News\Models;

use T4\Orm\Model;

class Topic
    extends Model
{
    static protected $schema = [
        'table' => 'newstopics',
        'columns' => [
            'title' => ['type'=>'string'],
        ]
    ];

    static protected $extensions = ['tree'];

} 