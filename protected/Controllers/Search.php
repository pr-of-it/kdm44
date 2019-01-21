<?php

namespace App\Controllers;

use App\Modules\Gallery\Models\Album;
use App\Modules\News\Models\Story;
use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

/**
 * Class Search
 * @package App\Controllers
 */
class Search extends Controller
{
    /**
     * Поиск
     *
     * @param null $query
     * @param int $page
     * @param string|null $subject
     * @throws \T4\Orm\Exception
     */
    public function actionDefault($query = null, $page = 1, string $subject = null)
    {
        $this->data->query = $query;
        if (null === $query || '' === $query) {
            return;
        }

        switch ($subject) {
            case null:
                $this->data->section = 'all';
                break;
            case 'news':
                $this->data->section = 'news';
                break;
            case 'pages':
                $this->data->section = 'pages';
                break;
            case 'albums':
                $this->data->section = 'albums';
                break;
        }

        $this->data->providers = [
            'stories' => new ModelDataProvider(Story::class, [
                'where' => 'MATCH (`title`, `lead`, `text`) AGAINST (:search)',
                'params' => [':search' => $query]
            ]),
            'pages' => new ModelDataProvider(Page::class, [
                'where' => 'MATCH (`title`, `url`, `text`) AGAINST (:search)',
                'params' => [':search' => $query]
            ]),
            'albums' => new ModelDataProvider(Album::class, [
                'where' => 'MATCH (`title`, `url`) AGAINST (:search)',
                'params' => [':search' => $query]
            ])
        ];

        $this->data->page = $page;
    }
}
