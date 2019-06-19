<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserLogin\RequestDto;
use App\Forms\SignInForm;
use T4\Core\MultiException;
use T4\Mvc\Controller;

/**
 * Class Send
 * @package App\Controllers
 */
class SignIn extends Controller
{
    /**
     * Вход
     *
     * @param null $return
     */
    public function actionDefault($return = null)
    {
        if (!empty($this->app->user)) {
            $this->redirect('/cabinet');
        }

        $form = (new SignInForm())->action('/signIn')->method('post');

        if (!empty($_POST)) {
            $form->setValue($_POST);

            if ($form->errors()->empty()) {
                try {
                    (new Identity())->authenticate($form->getValue(RequestDto::class));
                    $this->redirect($return ?: '/cabinet');
                } catch (MultiException $error) {
                    $this->data->errors = $error;
                } catch (\Throwable $exception) {
                    $this->data->errors = [$exception];
                }
            }
        }
        $this->data->old = $form->getValue();

        $this->data->form = $form;
    }
}
