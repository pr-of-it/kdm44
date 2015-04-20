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

    public function uploadImage($formFieldName)
    {
        $request = Application::getInstance()->request;
        if (!$request->existsFilesData() || !$request->isUploaded($formFieldName) || $request->isUploadedArray($formFieldName))
            return $this;

        try {
            $uploader = new Uploader($formFieldName);
            $uploader->setPath('/public/news/stories/images');
            $image = $uploader();
            if ($this->path)
                $this->deleteImage();
            $this->path = $image;
        } catch (Exception $e) {
            $this->path = null;
        }
        return $this;
    }

    public function uploadFiles($formFieldName)
    {
        $request = Application::getInstance()->request;
        if (!$request->existsFilesData() || !$request->isUploadedArray($formFieldName))
            return $this;

        $uploader = new Uploader($formFieldName);
        $uploader->setPath('/public/news/stories/images');
        print_r($this->images);
        foreach ($uploader() as $uploadedFilePath) {
            if (false !== $uploadedFilePath)
                $this->images->append(new Image(['path' => $uploadedFilePath]));
        }
        return $this;
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        $this->deleteFiles();
        return parent::beforeDelete();
    }

    public function deleteImage()
    {
        if ($this->path) {
            try {
                $this->path = '';
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->path);
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function deleteFiles()
    {
        if (!empty($this->path)) {
            try {
                $this->images = new Collection();
                foreach ($this->images as $image) {
                    Helpers::removeFile(ROOT_PATH_PUBLIC . $image->path);
                }
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }
}