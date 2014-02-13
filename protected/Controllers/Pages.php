<?php

namespace App\Controllers;

use App\Models\Page;
use T4\Mvc\Controller;

class Pages
    extends Controller
{

    public function actionPageText($id)
    {
        $page = Page::findByPK($id);
        $this->data->item = $page;
    }

}