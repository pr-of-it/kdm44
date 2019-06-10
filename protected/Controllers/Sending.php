<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserRegister\RequestDto;
use T4\Mvc\Controller;

/**
 * Class Sending
 * @package App\Controllers
 */
class Sending extends Controller
{
    /**
     * Отправка сообщения
     *
     * @param null $data
     */
    public function actionDefault($data = null)
    {
        $errors = [];
        try {
            $requestDto = RequestDto::createFromRequest($data);
        } catch (\Throwable $exception) {
            $errors[] = $exception;
        }

        if (!empty($errors)) {
            /** Если в запросе имеется personalAccount, то пробуем зарегистрировать пользователя */
            if (!empty($data->personalAccount)) {
                try {
                    (new Identity())->register($requestDto);
                } catch (\Throwable $exception) {
                    $errors[] = $exception;
                }
            }
        }

        if (empty($errors)) {
            $this->redirect('/letter');
        }

        $this->data->errors = $errors;
    }
}
