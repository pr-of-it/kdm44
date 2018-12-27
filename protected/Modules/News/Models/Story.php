<?php

namespace App\Modules\News\Models;

use App\Models\SearchableInterface;
use T4\Core\Collection;
use T4\Core\Exception;
use T4\Dbal\Query;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;
use T4\Orm\Model;

/**
 * Class Story
 * @package App\Modules\News\Models
 */
class Story extends Model implements SearchableInterface
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

    /**
     * @param string $string
     * @param null $limit
     * @return Story[]
     */
    public static function search(string $string, $limit = null)
    {
        if (empty($string)) {
            return [];
        }
        $query = (new Query())
            ->select()
            ->from(static::getTableName())
            ->where('MATCH (`title`, `lead`, `text`) AGAINST (:search)')
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
        return '/news/' . $this->getPk();
    }

    /**
     * @param int $maxLength
     * @return string|null
     */
    public function getShortLead($maxLength = 120)
    {
        $lead = isset($this->lead) ? $this->lead : null;
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

     public static function getItemsCountGroupByYears()
    {
        $query = "SELECT YEAR(published) AS year, COUNT(__id) AS count FROM " . self::getTableName() . " WHERE published <> '1970-01-01 00:00:00' GROUP BY YEAR(published) DESC";
        return self::getDbConnection()->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getItemsCountGroupByMonths($year)
    {
        $query = 'SELECT MONTH(published) AS month, COUNT(__id) AS count FROM ' . self::getTableName() . ' WHERE YEAR(published)=:year GROUP BY MONTH(published)';
        return self::getDbConnection()->query($query, [':year' => $year])->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $year
     * @param int $month
     * @return array
     */
    public static function getItemsCountGroupByTopic(int $year, int $month)
    {
        $query = <<<'SQL'
SELECT newstopics.`__id` AS id, newstopics.title, COUNT(newstopics.title) AS count
FROM newstopics
INNER JOIN newsstories 
  ON newstopics.`__id` = newsstories.`__topic_id`
       AND YEAR(`published`) = :year
       AND MONTH(`published`) = :month
GROUP BY newstopics.`__id`;
SQL;
        return self::getDbConnection()->query($query, [':year' => $year, ':month' => $month])->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $topic
     * @return Story[]
     */
    public static function getStoriesByTopic(int $year, int $month, int $topic)
    {
        $query = $query = (new Query())
            ->select()
            ->from(static::getTableName())
            ->where('YEAR(published)=:year AND MONTH(published)=:month AND `__topic_id`=:topic ORDER BY published DESC')
            ->param([':year'=>$year, ':month'=>$month, ':topic'=>$topic]);

        return static::findAllByQuery($query);
    }
}
