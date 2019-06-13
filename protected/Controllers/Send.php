<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserRegister\RequestDto;
use App\Forms\SendForm;
use App\Models\Statement;
use T4\Core\MultiException;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

/**
 * Class Send
 * @package App\Controllers
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

        $form = new SendForm();
        $errors = [];

        if (!empty($_POST)) {
            $form->setValue($_POST['data']);

            if ($form->errors()->empty()) {
                if (!empty($_POST['data']['personalAccount'])) {
                    try {
                        (new Identity())->register($form->getValue(RequestDto::class));
                    } catch (MultiException $exception) {
                        $errors = $exception;
                    } catch (\Throwable $exception) {
                        $errors = [$exception];
                    }
                }
                $data = array_merge($_POST['data'], ['type' => $url]);
                $data = array_merge($data, $_FILES);

                if (empty($errors)) {
                    $statement = new Statement();
                    try {
                        $statement->setFillByRequest($data);
                        $statement->save();
                        $this->redirect('/letter');
                    } catch (\Throwable $exception) {
                        $errors = [$exception];
                    }
                }
                $this->data->errors = $errors;
            }
        }
        $this->data->old = $form->getValue();

        $this->data->form = $form;
    }
}
