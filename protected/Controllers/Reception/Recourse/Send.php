<?php

namespace App\Controllers\Reception\Recourse;

use App\Components\Auth\Identity;
use App\Dto\UserRegister\RequestDto;
use App\Forms\RecourseSendForm;
use App\Models\Recourse;
use T4\Core\MultiException;
use T4\Http\E404Exception;
use T4\Http\Uploader;
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
        $errors = [];

        if (!empty($_POST)) {
            $form->setValue($_POST);
            $form->validatePassword();

            if ($form->errors()->empty()) {
                if (!empty($_POST['makePersonalAccount'])) {
                    try {
                        (new Identity())->register($form->getValue(RequestDto::class));
                    } catch (MultiException $exception) {
                        $errors = $exception;
                    } catch (\Throwable $exception) {
                        $errors = [$exception];
                    }
                }
                $data = array_merge($_POST, $_FILES, ['type' => $url]);

                if (empty($errors)) {
                    $recourse = new Recourse();
                    try {
                        $recourse->setFieldsByRequest($data);
                        $recourse->save();

                        $uploader = new Uploader('customFile');
                        $uploader->setPath('/public/recourses');
                        $files = $uploader();
                        $this->data->items = $files;

                        $this->redirect('/reception');
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
