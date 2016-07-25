<?php

namespace App\Modules\News\Models;

use T4\Core\Collection;
use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;
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
            'topic' => ['type'=>self::BELONGS_TO, 'model'=>\App\Modules\News\Models\Topic::class],
            'files' => ['type' => self::HAS_MANY, 'model' => \App\Modules\News\Models\File::class],
            'images' => ['type' => self::HAS_MANY, 'model' => \App\Modules\News\Models\Image::class],
        ]
    ];

    public function getShortLead($maxLength=120)
    {
        if (mb_strlen( $this->lead) > $maxLength){
            $sourceStr=strip_tags($this->lead);
            $words=explode(' ',mb_substr( $sourceStr,0,$maxLength));
            array_pop($words);
            return implode(' ',$words);
        }
        else
        {
            return $this->lead;
        }
    }

    public function uploadImage($formFieldName)
    {
        $request = Application::instance()->request;
        if (!$request->existsFilesData() || !$request->isUploaded($formFieldName) || $request->isUploadedArray($formFieldName))
            return $this;

        try {
            $uploader = new Uploader($formFieldName);
            $uploader->setPath('/public/news/stories/images');
            $image = $uploader();
            if ($this->image)
                $this->deleteImage();
            $this->image = $image;
        } catch (Exception $e) {
            $this->image = null;
        }
        return $this;
    }

    public function uploadFiles($formFieldName)
    {
        $request = Application::instance()->request;
        if (!$request->existsFilesData() || !$request->isUploadedArray($formFieldName)) {
             return $this;
        }
        $uploader = new Uploader($formFieldName);
        $uploader->setPath('/public/news/stories/files');
        foreach ($uploader() as $uploadedFilePath) {
            if (false !== $uploadedFilePath) {
                $this->files->append(new File(['file' => $uploadedFilePath]));
            }
        }
        return $this;
    }

    public function uploadImages($formFieldName)
    {
        $request = Application::instance()->request;
        if (!$request->existsFilesData() || !$request->isUploadedArray($formFieldName)) {
            return $this;
        }
        $uploader = new Uploader($formFieldName);
        $uploader->setPath('/public/news/photos');
        foreach ($uploader() as $uploadedFilePath) {
            if (false !== $uploadedFilePath) {
                $this->images->append(new Image(['path' => $uploadedFilePath]));
            }
        }
        return $this;
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        $this->deleteFiles();
        $this->deleteImages();
        return parent::beforeDelete();
    }

    public function deleteImage()
    {
        if ($this->image) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->image);
                $this->image = '';
                return true;
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function deleteFiles()
    {
        if (!empty($this->files)) {
            try {
                foreach ($this->files as $file) {
                    Helpers::removeFile(ROOT_PATH_PUBLIC . $file->file);
                }
                $this->files = new Collection();
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function deleteImages()
    {
        if (!empty($this->images)) {
            try {
                foreach ($this->images as $image) {
                    Helpers::removeFile(ROOT_PATH_PUBLIC . $image->path);
                }
                $this->images = new Collection();
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

     public static function getYears()
    {
        $query = 'SELECT YEAR(published) AS year, COUNT(__id) AS count FROM ' . self::getTableName() . ' WHERE published <> \'1970-01-01 00:00:00\'  GROUP BY YEAR(published) DESC';
        return self::getDbConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

}