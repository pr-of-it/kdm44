<?php

namespace App\Modules\Users\Controllers;

use App\Models\User;
use T4\Mvc\Controller;

class Admin
    extends Controller
{

    protected  $access = [
        'Default' => ['role.name'=>'admin']
    ];

    public function actionDefault()
    {
        $this->data->users = User::findAll();
    }

}