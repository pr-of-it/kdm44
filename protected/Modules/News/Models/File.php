<?php

namespace App\Modules\News\Models;

use T4\Orm\Model;
use T4\Fs\Helpers;

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

    public function afterDelete()
    {
        if($this->file){
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->file);
                $this->file='';
            }
            catch (\T4\Fs\Exception $e) {
            }
        }
        return parent::afterDelete();
    }
} 