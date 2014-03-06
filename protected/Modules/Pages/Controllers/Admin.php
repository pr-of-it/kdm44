<?php

namespace App\Modules\Pages\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Admin
    extends Controller
{

    public function actionDefault()
    {
        $this->data->pages = Page::findAllTree();
    }

    public function actionAdd()
    {
        $this->data->page = new Page();
    }

    public function actionSave()
    {
        if (!empty($_REQUEST[Page::PK])) {
            $page = Page::findByPK($_REQUEST[Page::PK]);
        } else {
            $page = new Page();
        }
        $page->fill($_REQUEST);
        $page->setParent($_REQUEST['parent']);
        $page->save();die;
        // flash !
        // redirect !!
    }

} 