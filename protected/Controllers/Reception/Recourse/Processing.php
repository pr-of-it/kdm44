<?php

namespace App\Controllers\Reception\Recourse;

use App\Dto\RecourseUpdate\RequestDto;
use App\Forms\RecourseUpdateForm;
use App\Models\Recourse;
use T4\Http\Uploader;
use T4\Mvc\Controller;
use T4\Orm\Exception;
use T4\Orm\ModelDataProvider;

/**
 * Обработка обращений
 *
 * Class Processing
 * @package App\Controllers\Reception\Recourse
 */
class Processing extends Controller
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
     * Отображение списка всех обращений
     *
     * @param int $page
     * @throws \T4\Orm\Exception
     */
    public function actionDefault($page = 1)
    {
        if (empty($this->app->user)) {
            $this->redirect('/signIn');
        }

        if (!$this->app->user->hasRole('committeeCollaborator')) {
            $this->redirect('/signIn');
        }

        $this->data->providers = [
            'recourses' => new ModelDataProvider(Recourse::class, [
                'order' => 'status, created_at DESC'
            ]),
        ];

        $this->data->page = $page;
    }

    /**
     * Редактирование обращений
     *
     * @param null $id
     */
    public function actionEdit($id = null)
    {
        if (empty($this->app->user)) {
            $this->redirect('/signIn');
        }

        if (!$this->app->user->hasRole('committeeCollaborator')) {
            $this->redirect('/signIn');
        }

        $recourse = Recourse::findByPK($id);
        $form = new RecourseUpdateForm();
        $errors = [];

        if (!empty($_POST)) {
            $form->setValue($_POST);

            if ($form->errors()->empty()) {
                try {
                    if (!empty($_FILES['fileAnswer']['name'])) {
                        $uploader = new Uploader('fileAnswer', self::ALLOWED_EXTENSIONS);
                        $uploader->setPath('/public/recourses/answers');
                        $files = $uploader();
                        $this->data->items = $files;
                        $recourse->file2 = $_FILES['fileAnswer']['name'];
                    }
                    $recourse->changeFieldsByRequest($form->getValue(RequestDto::class));
                    try {
                        $recourse->save();
                    } catch (\Exception $e) {
                        throw new Exception('Сохранение не выполнено. Возможно, вы указали уже существующий номер обращения');
                    }
                    $this->redirect('/reception/recourse/processing');
                } catch (\Throwable $exception) {
                    $errors = [$exception];
                }

                $this->data->errors = $errors;
            }

            $this->data->form = $form;

            $this->data->old = $form->getValue();
        }

        $this->data->user = $this->app->user;
        $this->data->item = $recourse;
    }
}
