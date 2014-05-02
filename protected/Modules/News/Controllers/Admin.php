<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
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
        $this->data->itemsCount = Story::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        $this->data->items = Story::findAll([
            'order' => 'published DESC',
            'limit'=>[($page-1)*self::PAGE_SIZE, self::PAGE_SIZE]
        ]);
    }

    public function actionEdit($id=null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new Story();
        } else {
            $this->data->item = Story::findByPK($id);
        }
    }

    public function actionSave()
    {
        if (!empty($_POST[Story::PK])) {
            $item = Story::findByPK($_POST[Story::PK]);
        } else {
            $item = new Story();
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
        $item = Story::findByPK($id);
        if ($item)
            $item->delete();
        $this->redirect('/admin#/news/admin');
    }

    public function actionTopics()
    {
        $this->data->items = Topic::findAllTree();
    }

    public function actionEditTopic($id=null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new Topic();
        } else {
            $this->data->item = Topic::findByPK($id);
        }
    }

    public function actionSaveTopic()
    {
        if (!empty($_POST[Topic::PK])) {
            $item = Topic::findByPK($_POST[Topic::PK]);
        } else {
            $item = new Topic();
        }
        $item
            ->fill($_POST)
            ->setParent($_POST['parent']);
        $item->save();
        $this->redirect('/admin#/news/admin/topics');
    }

    public function actionDeleteTopic($id)
    {
        $item = Topic::findByPK($id);
        if ($item)
            $item->delete();
        $this->redirect('/admin#/news/admin/topics');
    }

}