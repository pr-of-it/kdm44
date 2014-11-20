<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use T4\Core\Exception;
use T4\Core\Std;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
    }

    public function action404()
    {
    }

    public function actionLogin($email=null, $password=null, $return='/')
    {
        $this->data->error = $this->app->flash->error;
        if (!empty($email) && !empty($password)) {
            try {
                $identity = new Identity();
                $identity->authenticate(new Std(['email'=>$email, 'password'=>$password]));
                $this->redirect($return);
            } catch (Exception $e) {
                $this->app->flash->error = $e->getMessage();
            }
        }
        $this->data->email  = $email;
        $this->data->return = $return;
    }

    public function actionLogout()
    {
        $identity = new Identity();
        $identity->logout();
        $this->redirect('/');
    }

    public function actionBlockHtml($html='')
    {
        $this->data->html = $html;
    }

    public function actionMenu()
    {
        $this->data->items = \App\Models\Menu::findAllTree();
    }

}