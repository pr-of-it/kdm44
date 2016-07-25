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

    public function actionNewsByMonth($year = null)
    {
        $date = \DateTime::createFromFormat('Y', $year);
        if (null === $year || !$date) {
            throw new E404Exception;
        }
        if ($year !== $date->format('Y')) {
            throw new E404Exception;
        }

        $this->data->items = Story::getItemsCountGroupByMonths($year);
        $this->data->year = $year;
    }

}