<?php

namespace App\Controllers;

use App\Models\Recourse;
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
        $this->data->page = $this->app->request->get->page ?: 1;
        $this->data->total = Recourse::countAll();
        $this->data->size = $count;

        $recourses = Recourse::findAll(
            [
                'order' => 'created_at DESC',
                'offset' => ($this->data->page-1)*$count,
                'limit' => $count,
            ]
        );

        $this->data->items = $recourses;
    }
}
