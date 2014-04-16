<?php

namespace App\Modules\Pages\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Admin
    extends Controller
{

    protected  $access = [
        'Default' => ['role.name'=>'admin'],
        'Edit' => ['role.name'=>'admin'],
        'Save' => ['role.name'=>'admin'],
        'Delete' => ['role.name'=>'admin'],
        'Reorder' => ['role.name'=>'admin'],
    ];


    public function actionDefault()
    {
        $this->data->pages = Page::findAllTree();
    }

    public function actionEdit($id=null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->page = new Page();
        } else {
            $this->data->page = Page::findByPK($id);
        }
    }

    public function actionSave()
    {
        if (!empty($_POST[Page::PK])) {
            $page = Page::findByPK($_POST[Page::PK]);
        } else {
            $page = new Page();
        }
        $page
            ->fill($_POST)
            ->setParent($_POST['parent'])
            ->save();
        $this->redirect('/admin#/pages/admin');
    }

    public function actionDelete($id)
    {
        $page = Page::findByPK($id);
        if ($page)
            $page->delete();
        $this->redirect('/admin#/pages/admin');
    }

    public function actionReorder($ids)
    {
        var_dump($ids);die;
    }

}