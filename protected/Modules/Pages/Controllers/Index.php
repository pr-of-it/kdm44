<?php

namespace App\Modules\Pages\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Index
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

    public function actionPageByUrl($url)
    {
        $page = Page::findByUrl($url);
        $this->data->item = $page;
    }

    public function actionTree()
    {
        $this->data->items = Page::findAllTree();
    }

    public function actionSubTree($id)
    {
        $page = Page::findByPK($id);
        $this->data->items = $page->findSubTree();
    }

} 