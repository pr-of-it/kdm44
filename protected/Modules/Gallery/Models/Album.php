<?php

namespace App\Modules\Gallery\Models;


use App\Models\SearchableInterface;
use T4\Core\Collection;
use T4\Core\Std;
use T4\Dbal\Query;
use T4\Dbal\QueryBuilder;
use T4\Html\Form\Errors;
use T4\Orm\Model;

/**
 * Class Album
 * @package App\Modules\Gallery\Models
 */
class Album extends Model implements SearchableInterface
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
     * @param int|null $count
     * @return Album[]
     */
    public static function findLastAlbums(int $count = null)
    {
        return static::findAll(
            [
                'order' => 'published DESC',
                'limit' => $count,
            ]
        );
    }

    /**
     * @param string $string
     * @param null $limit
     * @return Album|array
     */
    public static function search(string $string, $limit = null)
    {
        if (empty($string)) {
            return [];
        }
        $query = (new Query())
            ->select()
            ->from(static::getTableName())
            ->where('MATCH (`title`, `url`) AGAINST (:search)')
            ->param(':search', $string);
        if (null !== $limit) {
            $query->limit($limit);
        }
        return static::findAllByQuery($query);
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return isset($this->__data['title']) ? $this->__data['title'] : null;
    }

    /**
     * @return string|null
     */
    public function getLead()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getSearchableItemUrl(): string
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