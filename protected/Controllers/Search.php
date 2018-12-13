<?php

namespace App\Controllers;

use App\Modules\News\Models\Story;
use T4\Mvc\Controller;

/**
 * Class Search
 * @package App\Controllers
 */
class Search extends Controller
{
    const DEFAULT_STORIES_COUNT = 10;

    /**
     * @param string $text
     */
    public function actionDefault($text = null)
    {
        $this->data->text = $text;
        if (null === $text || '' === $text) {
            return;
        }
        $this->data->items = Story::search($text);
    }
}
