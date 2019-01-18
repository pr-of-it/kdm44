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
                $this->data->activate = 'all';
                break;
            case 'news':
                $this->data->activate = 'news';
                break;
            case 'pages':
                $this->data->activate = 'pages';
                break;
            case 'albums':
                $this->data->activate = 'albums';
                break;
        }
        /** Провайдер для новостей */
        $this->data->providerStory = new ModelDataProvider(Story::class, [
            'where' => 'MATCH (`title`, `lead`, `text`) AGAINST (:search)',
            'params' => [':search' => $query],
        ]);
        $this->data->pageStory = $page;

        /** Провайдер для страниц */
        $this->data->providerPage = new ModelDataProvider(Page::class, [
            'where' => 'MATCH (`title`, `url`, `text`) AGAINST (:search)',
            'params' => [':search' => $query],
        ]);
        $this->data->pagePage = $page;

        /** Провайдер для альбомов */
        $this->data->providerAlbum = new ModelDataProvider(Album::class, [
            'where' => 'MATCH (`title`, `url`) AGAINST (:search)',
            'params' => [':search' => $query],
        ]);
        $this->data->pageAlbum = $page;

        $this->data->subject = $subject;
    }
}
