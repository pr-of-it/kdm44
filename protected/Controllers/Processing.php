<?php

namespace App\Controllers;

use App\Components\Auth\Identity;
use App\Models\Recourse;
use T4\Mvc\Controller;

/**
 * Обработка обращений
 *
 * Class Processing
 * @package App\Controllers
 */
class Processing extends Controller
{
    const DEFAULT_STATMENTS_COUNT = 5;

    /**
     * Отображение списка всех обращений
     *
     * @param int $count
     */
    public function actionDefault($count = self::DEFAULT_STATMENTS_COUNT)
    {
        if (!empty($this->app->user) &&  $this->app->user->hasRole('committeeCollaborator')) {
            $this->data->page = $this->app->request->get->page ?: 1;
            $this->data->total = Recourse::countAll();
            $this->data->size = $count;
            $this->data->user = $this->app->user;

            $recourses = Recourse::findAll(
                [
                    'order' => 'status, created_at DESC',
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
     * Редактирование обращений
     *
     * @param null $id
     */
    public function actionEdit($id = null)
    {
        if (!empty($this->app->user) &&  $this->app->user->hasRole('committeeCollaborator')) {
            $this->data->user = $this->app->user;
            $this->data->item = Recourse::find(['__id' => $id]);


        } else {
            $this->redirect('/signIn');
        }
    }

    /**
     * Выход из раздела обработки обращений
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
