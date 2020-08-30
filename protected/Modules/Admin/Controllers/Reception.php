<?php

namespace App\Modules\Admin\Controllers;

use App\Models\Recourse;
use T4\Mvc\Controller;

class Reception
    extends Controller
{

    const PAGE_SIZE = 20;

    protected function access($action,  $params = [])
    {
        return !empty($this->app->user) && $this->app->user->hasRole('admin');
    }

    public function actionRecourses($page = 1)
    {
        $this->data->itemsTotalCount = Recourse::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        $this->data->items = Recourse::findAll([
            'order' => 'created_at DESC',
            'offset'=> ($page-1)*self::PAGE_SIZE,
            'limit'=> self::PAGE_SIZE
        ]);
    }

    public function actionRecourse($id)
    {
        $this->data->item = Recourse::findByPK($id);
    }

}
