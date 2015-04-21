<?php
/**
 * Created by PhpStorm.
 * User: barricade
 * Date: 16.04.15
 * Time: 22:29
 */

namespace App\Modules\News\Models;

use T4\Core\Collection;
use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;
use T4\Orm\Model;

class Image extends Model
{
    static protected $schema = [
        'table' => 'newsimages',
        'columns' => [
            'path' => ['type'=>'string']
        ],
        'relations' => [
            'story' => ['type'=>self::BELONGS_TO, 'model'=>'\App\Modules\News\Models\Story'],
        ]
    ];


}