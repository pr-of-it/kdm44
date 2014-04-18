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

}