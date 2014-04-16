<?php

namespace App\Modules\News\Models;

use T4\Orm\Model;

class NewsStory
    extends Model
{
    static protected $schema = [
        'table' => 'newsstories',
        'columns' => [
            'title' => ['type'=>'string'],
            'published' => ['type'=>'datetime'],
            'lead' => ['type'=>'text'],
            'text' => ['type'=>'text'],
        ],
        'relations' => [
            'topic' => ['type'=>self::BELONGS_TO, 'model'=>'Modules\\News\\Models\\NewsTopic']
        ]
    ];

} 