<?php


namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{

    protected  $access = [
        'Default' => ['role.name'=>'admin']
    ];

    public function actionDefault()
    {
    }

}