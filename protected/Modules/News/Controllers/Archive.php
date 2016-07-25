<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

class Archive
    extends Controller
{
    public function actionDefault()
    {
        $this->data->items = Story::getItemsCountGroupByYears();
    }

    public function actionNewsByMonth(int $year = null)
    {
        if (null !== $year && \DateTime::createFromFormat('Y', $year)) {
            $this->data->items = Story::getItemsCountGroupByMonths($year);
        } else {
            throw new E404Exception;
        }

        $this->data->year = $year;
    }

}