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
    protected const ALLOWED_EXTENSIONS =
        [
            'txt', 'doc', 'docx', 'rtf',
            'xls', 'xlsx', 'pps', 'ppt',
            'odt', 'ods', 'odp', 'pub',
            'pdf', 'jpg', 'jpeg', 'bmp',
            'png', 'tif', 'gif', 'pcx',
            'mp3', 'wma', 'avi', 'mp4',
            'mkv', 'wmv', 'mov', 'flv'
        ];

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
                $data = array_merge($_POST, ['type' => $url]);

                if (empty($errors)) {
                    $recourse = new Recourse();
                    try {
                        if (!empty($_FILES['customFile']['name'])) {
                            $uploader = new Uploader('customFile', self::ALLOWED_EXTENSIONS);
                            $uploader->setPath('/public/recourses');
                            $files = $uploader();
                            $this->data->items = $files;
                            $recourse->file1 = $_FILES['customFile']['name'];
                        }
                        $recourse->setFieldsByRequest($data);
                        $recourse->save();

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
