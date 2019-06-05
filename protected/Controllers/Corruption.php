<?php

namespace App\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

/**
 * Class Corruption
 * @package App\Controllers
 */
class Corruption extends Controller
{
    /**
     * Сообщить о коррупции
     *
     * @throws \T4\Orm\Exception
     */
    public function actionDefault()
    {
        $page = Page::findByColumn('url', 'letter');
        $this->data->item = $page;
    }
}
