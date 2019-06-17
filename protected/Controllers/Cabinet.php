<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserUpdate\RequestDto;
use App\Forms\UserUpdateForm;
use App\Models\Recourse;
use function T4\app;
use T4\Mvc\Controller;

/**
 * Class Сabinet
 * @package App\Controllers
 */
class Cabinet extends Controller
{
    const DEFAULT_STATMENTS_COUNT = 5;

    /**
     * @param int $count
     */
    public function actionDefault($count = self::DEFAULT_STATMENTS_COUNT)
    {
        if (!empty(app()->user)) {
            $this->data->page = $this->app->request->get->page ?: 1;
            $this->data->total = Recourse::countAllByColumn('__user_id', $this->app->user->getPk());
            $this->data->size = $count;
            $this->data->user = app()->user;

            $recourses = Recourse::findAllByColumn(
                '__user_id', $this->app->user->getPk(),
                [
                    'order' => 'created_at DESC',
                    'offset' => ($this->data->page - 1) * $count,
                    'limit' => $count,
                ]
            );

            $this->data->items = $recourses;
        } else {
            $this->redirect('/signIn');
        }
    }

    /**
     * Профиль пользователя
     */
    public function actionProfile()
    {
        if (!empty(app()->user)) {

            $user = app()->user;
            if (!empty($_POST)) {
                if (!empty($_POST['password'])) {
                    $form = new UserUpdateForm();
                    $errors = [];

                    $form->setValue($_POST);

                    if ($form->errors()->empty()) {
                        try {
                            $user->setFieldsByRequest($form->getValue(RequestDto::class));
                            $user->save();
                            $this->redirect('/cabinet');
                        } catch (\Throwable $exception) {
                            $errors = [$exception];
                        }

                        $this->data->errors = $errors;
                    }
                } else {
                    $this->redirect('/cabinet');
                }
            }

            $this->data->form = $form;
            $this->data->user = $user;
        } else {
            $this->redirect('/signIn');
        }
    }

    /**
     * Выход из личного кабинета
     *
     * @return void
     */
    public function actionLogout(): void
    {
        if (!empty(app()->user)) {
            (new Identity())->logout();
        }
        $this->redirect('/reception');
    }
}
