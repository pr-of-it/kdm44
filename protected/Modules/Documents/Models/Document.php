<?php

namespace App\Modules\Documents\Models;

use T4\Orm\Model;

class Document
    extends Model
{

    static protected $schema = [
        'columns' => [
            'title' => [
                'type' => 'string',
                'length' => 1024,
            ],
            'published' => [
                'type' => 'date',
            ],
            'text' => [
                'type' => 'text',
                'length' => 'big',
            ],
        ],
        'relations' => [
            'category' => ['type'=>self::BELONGS_TO, 'model'=>\App\Modules\Documents\Models\Category::class]
        ],
    ];

} 