<?php


namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{

    protected function access($action, $params = [])
    {
        return !empty($this->app->user) && $this->app->user->hasRole('admin');
    }

    public function actionDefault()
    {
    }

}