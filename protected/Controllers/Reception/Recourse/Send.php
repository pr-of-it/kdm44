<?php

namespace App\Controllers\Reception\Recourse;

use App\Components\Auth\Identity;
use App\Dto\UserRegister\RequestDto;
use App\Forms\RecourseSendForm;
use T4\Core\MultiException;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

/**
 * Class Send
 * @package App\Controllers\Reception\Recourse
 */
class Send extends Controller
{
    /**
     * Обращение
     *
     * @param null $url
     * @throws E404Exception
     */
    public function actionDefault($url = null)
    {
        $this->data->query = $url;

        if ('send' === $url || 'corruption' === $url || 'collective-send' === $url) {
            switch ($url) {
                case 'send':
                    $this->data->query = 'send';
                    break;
                case 'corruption':
                    $this->data->query = 'corruption';
                    break;
                case 'collective-send':
                    $this->data->query = 'collective-send';
                    break;
            }
        } else {
            throw new E404Exception;
        }

        $form = new RecourseSendForm();

        if (!empty($_POST)) {
            $form->setValue($_POST);
            $form->validatePassword();

            if ($form->errors()->empty()) {
                if (!empty($_POST['personalAccount'])) {
                    try {
                        (new Identity())->register($form->getValue(RequestDto::class));
                        $this->redirect('/reception');
                    } catch (MultiException $exception) {
                        $this->data->errors = $exception;
                    } catch (\Throwable $exception) {
                        $this->data->errors = [$exception];
                    }
                }
            }
        }
        /** TODO: В дальнейшем будет добавлена регистрация обращений */

        $this->data->old = $form->getValue();

        $this->data->form = $form;
    }
}
