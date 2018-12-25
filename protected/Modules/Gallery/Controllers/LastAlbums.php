<?php

namespace App\Modules\Gallery\Controllers;

use App\Modules\Gallery\Models\Album;
use T4\Mvc\Controller;

/**
 * Class LastAlbums
 * @package App\Modules\Gallery\Controllers
 */
class LastAlbums extends Controller
{
    /**
     * @param int|null $count
     */
    public function actionDefault(int $count = null)
    {
        $this->data->albums = Album::findLastAlbums($count);
    }
}
