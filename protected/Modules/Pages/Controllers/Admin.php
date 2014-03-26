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

    public function actionEdit($id)
    {
        $this->data->page = Page::findByPK($id);
    }

    public function actionSave()
    {
        if (!empty($_POST[Page::PK])) {
            $page = Page::findByPK($_POST[Page::PK]);
        } else {
            $page = new Page();
        }
        $page->fill($_POST);
        $page->setParent($_POST['parent']);
        $page->save();
        $this->redirect('/admin#/pages/admin');
    }

    public function actionDelete($id)
    {
        $page = Page::findByPK($id);
        $page->delete();
        $this->redirect('/admin#/pages/admin');
    }

    public function actionReorder($ids)
    {
        var_dump($ids);die;
    }

}