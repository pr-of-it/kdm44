<?php

namespace App\Modules\Pages\Models;

use T4\Core\Collection;
use T4\Core\Std;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Orm\Model;

class Page
    extends Model
{

    static protected $schema = [
        'columns' => [
            'title' => [
                'type' => 'string',
            ],
            'url' => [
                'type' => 'string',
            ],
            'template' => [
                'type' => 'string',
            ],
            'text' => [
                'type' => 'text',
                'length' => 'big',
            ],
            'order' => [
                'type' => 'int',
                'default' => 0
            ],
            'file' => [
                'type' => 'string',
            ],
        ],
        'relations' => [
            'files' => ['type' => self::HAS_MANY, 'model' => '\App\Modules\Pages\Models\File']
        ],
    ];

    static protected $extensions = ['tree'];

    public function getBreadCrumbs()
    {
        $ret = new Collection;
        foreach ($this->findAllParents() as $i => $parent) {
            if (0==$i)
                continue;
            $p = new Std;
            $p->url = $parent->url;
            $p->title = $parent->title;
            $ret[] = $p;
        }
        return $ret;
    }

    public function beforeSave()
    {
        var_dump($_FILES);die;
        $uploader = new Uploader('file');
        if ($uploader->isUploaded()) {
            try {
                $this->deleteFiles();
                $uploader->setPath('/public/pages');
                $file = new File();
                $file->file = $uploader();
                $this->files = new Collection([$file]);
            } catch (Exception $e) {
                $this->files = new Collection();
            }
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $this->deleteFiles();
        $this->files = new Collection();
        return parent::beforeDelete();
    }

    public function deleteFiles()
    {
        if (!empty($this->files)) {
            try {
                foreach ($this->files as $file) {
                    Helpers::removeFile(ROOT_PATH_PUBLIC . $file->file);
                }
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}