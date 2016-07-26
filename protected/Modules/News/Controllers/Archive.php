<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use T4\Http\E404Exception;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

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

    public function actionNewsByDay(int $year = null, int $month = null, int $page = 1)
    {
        if (null  === $year  || 
            null  === $month ||
            false === \DateTime::createFromFormat('Y', $year) ||
            false === \DateTime::createFromFormat('m', $month)
        ) {
            throw new E404Exception;
        }

        $provider = 
            (new ModelDataProvider(Story::class, [
                'where' => 'YEAR(published)=:year AND MONTH(published)=:month',
                'order' => 'published',
                'params' => [':year' => $year, ':month' => $month],
            ]))
            ->setPageSize(self::DEFAULT_STORIES_COUNT);
        
        $this->data->provider = $provider;
        $this->data->page = $page;
        
        $this->data->year = $year;
        $this->data->month = $month;
    }
}