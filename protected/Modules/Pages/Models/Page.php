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
        $uploader = new Uploader('file');
        if ($uploader->isUploaded()) {
            try {
                $this->deleteFile();
                $uploader->setPath('/public/pages');
                $this->file = $uploader();
            } catch (Exception $e) {
                $this->file = null;
            }
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $this->deleteFile();
        return parent::beforeDelete();
    }

    public function deleteFile()
    {
        if ($this->file) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->file);
                $this->file = '';
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}