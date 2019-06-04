<?php

namespace App\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

/**
 * Class Letter
 * @package App\Controllers
 */
class Letter extends Controller
{
    /**
     * Электронная приёмная
     *
     * @throws \T4\Orm\Exception
     */
    public function actionDefault()
    {
        $page = Page::findByColumn('title', 'Электронная приёмная');
        $this->data->item = $page;
    }
}
