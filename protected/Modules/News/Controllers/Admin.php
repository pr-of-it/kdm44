<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\NewsStory;
use T4\Mvc\Controller;

class Admin
    extends Controller
{

    const PAGE_SIZE = 20;

    protected  $access = [
        'Default' => ['role.name'=>'admin'],
        'Edit' => ['role.name'=>'admin'],
        'Save' => ['role.name'=>'admin'],
    ];


    public function actionDefault($page = 1)
    {
        $this->data->itemsCount = NewsStory::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        $this->data->items = NewsStory::findAll([
            'order' => 'published DESC',
            'limit'=>[($page-1)*self::PAGE_SIZE, self::PAGE_SIZE]
        ]);
    }

    public function actionEdit($id=null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new NewsStory();
        } else {
            $this->data->item = NewsStory::findByPK($id);
        }
    }

    public function actionSave()
    {
        if (!empty($_POST[NewsStory::PK])) {
            $item = NewsStory::findByPK($_POST[NewsStory::PK]);
        } else {
            $item = new NewsStory();
        }
        $item
            ->fill($_POST);
        if ($item->isNew()) {
            $item->published = date('Y-m-d H:i:s', time());
        }
        $item->save();
        $this->redirect('/admin#/news/admin');
    }

    public function actionDelete($id)
    {
        $item = NewsStory::findByPK($id);
        if ($item)
            $item->delete();
        $this->redirect('/admin#/news/admin');
    }

}