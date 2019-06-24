<?php

namespace App\Controllers\Reception\Recourse;

use App\Models\Recourse;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

/**
 * Обработка обращений
 *
 * Class Processing
 * @package App\Controllers\Reception\Recourse
 */
class Processing extends Controller
{
    /**
     * Отображение списка всех обращений
     *
     * @param int $page
     * @throws \T4\Orm\Exception
     */
    public function actionDefault($page = 1)
    {
        if (!empty($this->app->user) &&  $this->app->user->hasRole('committeeCollaborator')) {
            $this->data->providers = [
                'recourses' => new ModelDataProvider(Recourse::class, [
                    'order' => 'status, created_at DESC'
                ]),
            ];

            $this->data->page = $page;
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
}
