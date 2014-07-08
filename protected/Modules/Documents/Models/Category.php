<?php

namespace App\Modules\Documents\Models;

use T4\Orm\Model;

class Category
    extends Model
{

    static protected $schema = [
        'table' => 'document_cats',
        'columns' => [
            'title' => [
                'type' => 'string',
                'length' => 1024,
            ],
            'url' => [
                'type' => 'string',
            ],
        ]
    ];

    static protected $extensions = ['tree'];

} 