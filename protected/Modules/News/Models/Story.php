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
            'title' => ['type' => 'string'],
            'published' => ['type' => 'datetime'],
            'lead' => ['type' => 'text'],
            'image' => ['type' => 'string', 'default' => ''],
            'text' => ['type' => 'text'],
        ],
        'relations' => [
            'topic' => ['type' => self::BELONGS_TO, 'model' => 'App\Modules\News\Models\Topic'],
            'files' => ['type' => self::HAS_MANY, 'model' => '\App\Modules\News\Models\File'],
            'images' => ['type' => self::HAS_MANY, 'model' => '\App\Modules\News\Models\Image'],
        ]
    ];

    public function getShortLead($maxLength = 120)
    {
        if (mb_strlen($this->lead) > $maxLength) {
            $sourceStr = strip_tags($this->lead);
            $words = explode(' ', mb_substr($sourceStr, 0, $maxLength));
            array_pop($words);
            return implode(' ', $words);
        } else {
            return $this->lead;
        }
    }

    public function uploadImage($formFieldName)
    {
        $request = Application::getInstance()->request;
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
        $request = Application::getInstance()->request;
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
        $request = Application::getInstance()->request;
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

    static public function getYears()
    {
        $query = 'SELECT DISTINCT(YEAR(published)) FROM ' . self::getTableName() . ' ORDER BY YEAR(published) DESC';
        return self::findAllByQuery($query);
    }

    static public function countAllByDate($year = null, $month = null, $day = null)
    {
        $valuewhere =
            (!empty($year) ? ' YEAR(published) = :year' : '') .
            (!empty($month) ? ' AND MONTH(published) = :month' : '') .
            (!empty($day) ? ' AND DAY(published) = :day' : '');
        if (!empty($year)) {
            $params = [':year' => $year];
        }
        if (!empty($month)) {
            $params += [':month' => $month];
        }
        if (!empty($day)) {
            $params += [':day' => $day];
        }
        $options = [
            'where' => $valuewhere,
            'params' => $params,
        ];
        return self::countAll($options);
    }

    static public function countAllByDateColumn($column, $value, $year = null, $month = null, $day = null)
    {
        $wherevalue =
            (!empty($year) ? ' YEAR(published) = :year' : '') .
            (!empty($month) ? ' AND MONTH(published) = :month' : '') .
            (!empty($day) ? ' AND DAY(published) = :day' : '') .
            (!empty($column) ? ' AND `' . $column . '`=:value ' : '');
        if (!empty($year)) {
            $params = [':year' => $year];
        }
        if (!empty($month)) {
            $params += [':month' => $month];
        }
        if (!empty($day)) {
            $params += [':day' => $day];
        }
        if (!empty($value)) {
            $params += [':value' => $value];
        }
        $options = [
            'where' => $wherevalue,
            'params' => $params,
        ];
        return self::countAll($options);
    }
}