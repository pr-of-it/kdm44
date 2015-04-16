<?php

namespace App\Modules\Gallery\Models;


use T4\Core\Collection;
use T4\Core\Std;
use T4\Dbal\QueryBuilder;
use T4\Html\Form\Errors;
use T4\Orm\Model;

class Album
    extends Model
{

    protected static $schema = [
        'columns' => [
            'title' => ['type' => 'string'],
            'url' => ['type' => 'string'],
            'published' => ['type' => 'datetime'],
        ],
        'relations' => [
            'photos' => ['type' => self::HAS_MANY, 'model' => Photo::class],
        ]
    ];

    static protected $extensions = ['tree'];

    public function beforeSave()
    {
        if ($this->isNew()) {
            $this->published = date('Y-m-d H:i:s', time());
        }
        $query = new QueryBuilder();
        $query
            ->select('COUNT(*)')
            ->from(self::getTableName());

        if ($this->isNew()) {
            $query->where('url=:url')->params([':url' => $this->url]);
        } else {
            $query
                ->where('url=:url AND __id<>:id')
                ->params([':url' => $this->url, ':id' => $this->getPk()]);
        }
        $count = self::getDbConnection()->query($query)->fetchScalar();

        switch ($count) {
            case 0:
                return parent::beforeSave();
                break;
            default:
                $errors = new Errors();
                $errors->add('url', 'Альбом с такими URL уже существует');
                throw $errors;
                break;
        }
    }

    public function afterDelete()
    {
        $this->photos->delete();
    }

    public function getCover()
    {
        if ($this->__photo_id) {
            return $this->cover->image;
        } else {
            if (is_array($this->photos->collect('published'))) {
                $key = array_search(max($this->photos->collect('published')), $this->photos->collect('published'));
                return $this->photos->collect('image')[$key];
            } else {
                return $this->photos->collect('image');
            }
        }
    }

    public function getBreadCrumbs()
    {
        $ret = new Collection();
        foreach ($this->findAllParents() as $i => $parent) {
            $p = new Std;
            $p->Pk = $parent->Pk;
            $p->url = $parent->url;
            $p->title = $parent->title;
            $ret[] = $p;
        }
        return $ret;
    }

    public function countPhotos()
    {
        return count($this->photos->collect('image'));
    }
}