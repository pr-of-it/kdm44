<?php

namespace App\Modules\Pages\Models;

use App\Models\SearchableInterface;
use T4\Core\Collection;
use T4\Core\Std;
use T4\Dbal\Query;
use T4\Dbal\QueryBuilder;
use T4\Fs\Helpers;
use T4\Html\Form\Errors;
use T4\Http\Uploader;
use T4\Mvc\Application;
use T4\Orm\Model;

/**
 * Class Page
 * @package App\Modules\Pages\Models
 */
class Page extends Model implements SearchableInterface
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
        ],
        'relations' => [
            'files' => ['type' => self::HAS_MANY, 'model' => \App\Modules\Pages\Models\File::class]
        ],
    ];

    static protected $extensions = ['tree'];

    /**
     * @param string $string
     * @param null $limit
     * @return Page[]
     */
    public static function search(string $string, $limit = null)
    {
        if (empty($string)) {
            return [];
        }
        $query = (new Query())
            ->select()
            ->from(static::getTableName())
            ->where('MATCH (`title`, `url`, `text`) AGAINST (:search)')
            ->param(':search', $string);
        if (null !== $limit) {
            $query->limit($limit);
        }
        return static::findAllByQuery($query);
    }

    /**
     * @return string|null
     */
    public function getSearchableItemTitle()
    {
        return isset($this->title) ? $this->title : null;
    }

    /**
     * @return string|null
     */
    public function getSearchableItemLead()
    {
        return $this->getShortLead();
    }

    /**
     * @return string
     */
    public function getSearchableItemUrl(): string
    {
        return '/pages/' . $this->url;
    }

    /**
     * @param int $maxLength
     * @return string|null
     */
    public function getShortLead($maxLength = 120)
    {
        $lead = isset($this->text) ? $this->text : null;
        if (null === $lead) {
            return;
        }
        if (mb_strlen($lead) > $maxLength) {
            $sourceStr = strip_tags($lead);
            $words = explode(' ', mb_substr($sourceStr, 0, $maxLength));
            array_pop($words);
            return implode(' ', $words);
        }
        return $lead;
    }

    public function getBreadCrumbs()
    {
        $ret = new Collection;
        foreach ($this->findAllParents() as $i => $parent) {
            if (0 == $i)
                continue;
            $p = new Std;
            $p->url = $parent->url;
            $p->title = $parent->title;
            $ret[] = $p;
        }
        return $ret;
    }

    public function uploadFiles($formFieldName)
    {
        $request = Application::instance()->request;
        if (!$request->existsFilesData() || !$request->isUploadedArray($formFieldName))
            return $this;

        $uploader = new Uploader($formFieldName);
        $uploader->setPath('/public/pages');
        foreach ($uploader() as $uploadedFilePath) {
            if (false !== $uploadedFilePath)
                $this->files->append(new File(['file' => $uploadedFilePath]));
        }
        return $this;
    }

    public function beforeSave()
    {
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
                $errors->add('url', 'Страница с такими URL уже существует');
                throw $errors;
                break;
        }
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