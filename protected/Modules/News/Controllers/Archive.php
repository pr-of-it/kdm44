<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

class Archive
    extends Controller
{
    const DEFAULT_STORIES_COUNT = 20;

    public function actionDefault()
    {
        $this->data->items = Story::getItemsCountGroupByYears();
    }

    public function actionNewsByMonth(int $year = null)
    {
        if (null === $year || false === \DateTime::createFromFormat('Y', $year)) {
            throw new E404Exception;
        }

        $this->data->items = Story::getItemsCountGroupByMonths($year);
        $this->data->year = $year;
    }

    public function actionNewsByDay(int $year = null, int $month = null)
    {
        if (null  === $year  || 
            null  === $month ||
            false === \DateTime::createFromFormat('Y', $year) ||
            false === \DateTime::createFromFormat('m', $month)
        ) {
            throw new E404Exception;
        }

        $this->data->page = $this->app->request->get->page ?: 1;
        $this->data->total = Story::countItemsByMonth($year, $month);
        $this->data->size = self::DEFAULT_STORIES_COUNT;

        $this->data->items = Story::getItemsByMonth($year, $month, $this->data->page, self::DEFAULT_STORIES_COUNT);
        $this->data->year = $year;
        $this->data->month = $month;
    }
}