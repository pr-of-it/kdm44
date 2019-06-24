<?php

namespace App\Controllers\Reception\Recourse;

use App\Models\Recourse;
use T4\Mvc\Controller;

/**
 * Class Answer
 * @package App\Controllers\Reception\Recourse
 */
class Answer extends Controller
{
    /**
     * @param null $date
     * @param null $number
     */
    public function actionDefault($date = null, $number = null)
    {
        $this->data->date = $date;
        $this->data->number = $number;
        $this->data->item = Recourse::find(
            [
                'where' => 'type = :type AND status = :status AND number LIKE :number AND DATE(created_at) = :date',
                'params' => [':number' => $number, ':date' => $date, ':type' => 'answer-to-recourse', ':status' => 'withAnswer']
            ]
        );

        $this->data->old = ['date' => $date, 'number' => $number];
    }
}
