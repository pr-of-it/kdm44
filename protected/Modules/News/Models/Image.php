<?php
/**
 * Created by PhpStorm.
 * User: barricade
 * Date: 16.04.15
 * Time: 22:29
 */

namespace App\Modules\News\Models;
use T4\Fs\Helpers;

use T4\Orm\Model;

class Image extends Model
{
    static protected $schema = [
        'table' => 'newsimages',
        'columns' => [
            'path' => ['type'=>'string']
        ],
        'relations' => [
            'story' => ['type'=>self::BELONGS_TO, 'model'=>\App\Modules\News\Models\Story::class],
        ]
    ];

    public function afterDelete()
    {
        if($this->path){
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC.$this->path);
                $this->path='';
            }
            catch (\T4\Fs\Exception $e) {
            }
        }
        return parent::afterDelete();
    }
}