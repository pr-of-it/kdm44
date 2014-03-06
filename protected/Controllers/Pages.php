<?php

namespace App\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Pages
    extends Controller
{

    public function actionPageText($id)
    {
        $page = Page::findByPK($id);
        $this->data->item = $page;
    }

    public function actionPage($id)
    {
        $page = Page::findByPK($id);
        $this->data->item = $page;
    }

}