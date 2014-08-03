<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Controller;
use T4\Core\Exception;
use T4\Core\Std;

class News
    extends Controller
{

    const PAGE_SIZE = 20;

    protected $access = [
        'Default' => ['role.name'=>'admin'],
        'Edit' => ['role.name'=>'admin'],
        'Save' => ['role.name'=>'admin'],
        'Delete' => ['role.name'=>'admin'],
        'UploadPhoto' => ['role.name'=>'admin'],
        'DeletePhoto' => ['role.name'=>'admin'],

        'Topics' => ['role.name'=>'admin'],
        'EditTopic' => ['role.name'=>'admin'],
        'SaveTopic' => ['role.name'=>'admin'],
        'DeleteTopic' => ['role.name'=>'admin'],
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
        $this->app->extensions->ckeditor->init();

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
        $item->fill($_POST);
        if ($item->isNew()) {
            $item->published = date('Y-m-d H:i:s', time());
        }
        $item->save();
        $this->redirect('/admin/news/');
    }

    public function actionDelete($id)
    {
        $item = Story::findByPK($id);
        $item->delete();
        $this->redirect('/admin/news/');
    }

    public function actionDeletePhoto($id)
    {
        $item = Story::findByPK($id);
        if ($item) {
            $item
                ->deleteImage()
                ->save();
            $this->data = true;
        } else {
            $this->data = false;
        }
    }

    /**
     * TOPICS
     */

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
        $item->fill($_POST);
        $item->save();
        $this->redirect('/admin/news/topics/');
    }

    public function actionDeleteTopic($id)
    {
        $item = Topic::findByPK($id);
        if ($item) {
            $item->delete();
        }
        $this->redirect('/admin/news/topics/');
    }

}