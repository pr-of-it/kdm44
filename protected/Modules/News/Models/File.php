<?php

namespace App\Modules\News\Models;

use T4\Orm\Model;

class File
    extends Model
{

    static protected $schema = [
        'table' => 'newsfiles',
        'columns' => [
            'file' => ['type' => 'string'],
        ],
        'relations' => [
            'story' => ['type' => self::BELONGS_TO, 'model' => '\App\Modules\News\Models\Story'],
        ],
    ];

} 