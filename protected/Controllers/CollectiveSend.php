<?php

namespace App\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

/**
 * Class CollectiveSend
 * @package App\Controllers
 */
class CollectiveSend extends Controller
{
    /**
     * Коллективное письмо
     *
     * @throws \T4\Orm\Exception
     */
    public function actionDefault()
    {
        $page = Page::findByColumn('url', 'letter');
        $this->data->item = $page;
    }
}
