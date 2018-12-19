<?php

namespace App\Controllers;

use App\Modules\Gallery\Models\Album;
use App\Modules\News\Models\Story;
use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

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

        $this->data->stories = Story::search($query);
        $this->data->pages = Page::search($query);
        $this->data->albums = Album::search($query);
    }
}
