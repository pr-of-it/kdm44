<?php

namespace App\Modules\Pages\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;
use T4\Http\E404Exception;

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
        if (empty($this->data->item)) {
            throw new E404Exception;
        }
    }

    public function actionTree()
    {
        $this->data->items = Page::findAllTree();
    }

    public function actionSubTree($id, $includeParent = false)
    {
        $page = Page::findByPK($id);
        if ($includeParent)
            $this->data->items = $page->findSubTree();
        else
            $this->data->items = $page->findAllChildren();
    }

} 