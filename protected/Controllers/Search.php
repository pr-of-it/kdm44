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
     * @param string $text
     */
    public function actionDefault($text = null)
    {
        $this->data->text = $text;
        if (null === $text || '' === $text) {
            return;
        }

        $this->data->stories = Story::search($text);
        $this->data->pages = Page::search($text);
        $this->data->albums = Album::search($text);
    }
}
