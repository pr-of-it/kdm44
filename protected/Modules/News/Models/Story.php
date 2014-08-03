<?php

namespace App\Modules\News\Models;

use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Orm\Model;

class Story
    extends Model
{
    static protected $schema = [
        'table' => 'newsstories',
        'columns' => [
            'title' => ['type'=>'string'],
            'published' => ['type'=>'datetime'],
            'lead' => ['type'=>'text'],
            'image' => ['type'=>'string', 'default'=>''],
            'text' => ['type'=>'text'],
        ],
        'relations' => [
            'topic' => ['type'=>self::BELONGS_TO, 'model'=>'App\Modules\News\Models\Topic']
        ]
    ];

    public function beforeSave()
    {
        $uploader = new Uploader('image');
        if ($uploader->isUploaded()) {
            try {
                $this->deleteImage();
                $uploader->setPath('/public/news/stories');
                $this->image = $uploader();
            } catch (Exception $e) {
                $this->image = null;
            }
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function deleteImage()
    {
        if ($this->image) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->image);
                $this->image = '';
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}