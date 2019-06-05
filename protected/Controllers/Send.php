<?php

namespace App\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

/**
 * Class Send
 * @package App\Controllers
 */
class Send extends Controller
{
    /**
     * Написать письмо
     *
     * @throws \T4\Orm\Exception
     */
    public function actionDefault()
    {
        $page = Page::findByColumn('url', 'letter');
        $this->data->item = $page;
    }
}
