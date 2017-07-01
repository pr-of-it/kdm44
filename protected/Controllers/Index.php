<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use T4\Core\Exception;
use T4\Core\Std;
use T4\Http\E404Exception;
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

    public function actionPassword($oldPassword = null, $newPassword1 = null, $newPassword2 = null, $return = '/')
    {
        if (!$this->app->user)
            throw new E404Exception();

        if (!empty($oldPassword) && !empty($newPassword1) && !empty($newPassword2)) {

            try {
                $identity = new Identity();
                $identity->check(new Std(['email' => $this->app->user->email, 'password' => $oldPassword]));
            } catch (Exception $e) {
                $this->data->error = 'Неверный текущий пароль';
            }

            if ($newPassword1 != $newPassword2) {
                $this->data->error = 'Введенные пароли не совпадают!';
            }

            if (empty($this->data->error)) {
                $this->app->user->password = password_hash($newPassword1, PASSWORD_DEFAULT);
                $this->app->user->save();
                $this->app->flash->message = 'Пароль успешно изменен!';
                $this->redirect($return);
            }

        }
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