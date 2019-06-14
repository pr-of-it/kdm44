<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserRegister\RequestDto;
use App\Forms\SendForm;
use App\Forms\SignInForm;
use App\Models\Statement;
use function T4\app;
use T4\Core\MultiException;
use T4\Http\E404Exception;
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
        if (!empty(app()->user)) {
            $this->redirect('/cabinet');
        }

        $form = (new SignInForm())->action('/signIn')->method('post');

        if (!empty($_POST)) {
            $form->setValue($_POST);

            if ($form->errors()->empty()) {
                try {
                    (new Identity())->authenticate($form->getValueAsObject());
                    $this->redirect($return ?: '/letter');
                } catch (MultiException $error) {
                    $this->data->errors = $error;
                } catch (\Throwable $exception) {
                    $this->data->errors = [$exception];
                }
            }
        }

        $this->data->form = $form;
    }
}
