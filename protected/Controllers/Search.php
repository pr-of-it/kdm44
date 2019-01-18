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
     */
    public function actionDefault($query = null, $page = 1)
    {
        $this->data->query = $query;
        if (null === $query || '' === $query) {
            return;
        }

        $this->data->providerStory = new ModelDataProvider(Story::class, [
            'where' => 'MATCH (`title`, `lead`, `text`) AGAINST (:search)',
            'params' => [':search' => $query],
        ]);
        $this->data->pageStory = $page;
        //var_dump($this->data->provider);die;

        $this->data->providerPage = new ModelDataProvider(Page::class, [
            'where' => 'MATCH (`title`, `url`, `text`) AGAINST (:search)',
            'params' => [':search' => $query],
        ]);
        $this->data->pagePage = $page;


        /*$count = 5;
        $this->data->page = $this->app->request->get->page ?: 1;
        $this->data->total = Story::search($query)->count();
        $this->data->size = $count;*/

        //$this->data->stories = Story::search($query);
        //$this->data->pages = Page::search($query);
        $this->data->albums = Album::search($query);
    }
}
