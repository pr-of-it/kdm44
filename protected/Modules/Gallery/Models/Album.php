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
            'cover' => ['type' => self::BELONGS_TO, 'model' => Photo::class, 'on' => '__cover_id'],
        ]
    ];

    static protected $extensions = ['tree'];

    /**
     * @param int|null $limit
     * @return Album[]
     */
    public static function findLastAlbums(int $limit = null)
    {
        return static::findAll(
            [
                'order' => 'published DESC',
                'limit' => $limit,
            ]
        );
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return isset($this->__data['title']) ? $this->__data['title'] : null;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return '/gallery/albums/' . $this->__data['url'];
    }

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