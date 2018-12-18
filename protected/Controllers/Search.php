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
     * @param null $searchstring
     */
    public function actionDefault($searchstring = null)
    {
        $this->data->searchstring = $searchstring;
        if (null === $searchstring || '' === $searchstring) {
            return;
        }

        $this->data->stories = Story::search($searchstring);
        $this->data->pages = Page::search($searchstring);
        $this->data->albums = Album::search($searchstring);
    }
}
