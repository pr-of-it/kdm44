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
    public function actionDefault($query = null)
    {
        $this->data->query = $query;
        if (null === $query || '' === $query) {
            return;
        }
        $page = 1;
        $this->data->page = $this->app->request->get->page ?: 1;

        $this->data->provider = new ModelDataProvider(Story::class);
        $this->data->page = $page;

        $this->data->stories = Story::search($query);
        $this->data->pages = Page::search($query);
        $this->data->albums = Album::search($query);
    }
}
