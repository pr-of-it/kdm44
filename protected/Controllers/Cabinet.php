<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Dto\UserUpdate\RequestDto;
use App\Forms\UserUpdateForm;
use App\Models\Recourse;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

/**
 * Class Сabinet
 * @package App\Controllers
 */
class Cabinet extends Controller
{
    /**
     * @param int $page
     * @throws \T4\Orm\Exception
     */
    public function actionDefault($page = 1)
    {
        if (empty($this->app->user)) {
            $this->redirect('/signIn');
        }

        $this->data->user = $this->app->user;
        $this->data->providers = [
            'recourses' => new ModelDataProvider(Recourse::class, [
                'where' => '__user_id = '. $this->app->user->getPk(),
                'order' => 'created_at DESC'
            ]),
        ];

        $this->data->page = $page;
    }

    /**
     * Профиль пользователя
     */
    public function actionProfile()
    {
        if (empty($this->app->user)) {
            $this->redirect('/signIn');
        }

        $user = $this->app->user;
        if (!empty($_POST)) {
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
            $this->data->old = $form->getValue();
        }

        $this->data->form = $form;
        $this->data->user = $user;
    }

    /**
     * Выход из личного кабинета
     *
     * @return void
     */
    public function actionLogout(): void
    {
        if (!empty($this->app->user)) {
            (new Identity())->logout();
        }
        $this->redirect('/reception');
    }
}
