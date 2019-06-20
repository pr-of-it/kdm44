<?php

namespace App\Controllers;

use App\Models\Recourse;
use T4\Mvc\Controller;

/**
 * Class Answer
 * @package App\Controllers
 */
class Answer extends Controller
{
    public function actionDefault($date = null, $number = null)
    {
        $this->data->date = $date;
        $this->data->number = $number;
        $this->data->item = Recourse::find(
            [
                'where' => 'type = :type && status = :status && number LIKE :number && DATE(created_at) = :date',
                'params' => [':number' => $number, ':date' => $date, ':type' => 'answer-to-recourse', ':status' => 'withAnswer']
            ]
        );

        $this->data->old = ['date' => $date, 'number' => $number];
    }
}
