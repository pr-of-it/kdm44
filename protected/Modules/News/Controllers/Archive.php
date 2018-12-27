<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use T4\Http\E404Exception;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

class Archive
    extends Controller
{

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

    public function actionNewsByTopic(int $year = null, int $month = null)
    {
        if (0 > $month || 12 < $month
            || null === \DateTime::createFromFormat('Y-m', $year . '-' . $month)) {
            throw new E404Exception;
        }

        $this->data->topics = Story::getItemsCountGroupByTopic($year, $month);

        $this->data->year = $year;
        $this->data->month = $month;
    }

    public function actionNewsByDay(int $year = null, int $month = null, int $topic = null, int $page = 1)
    {
        if (0 > $month || 12 < $month || null === \DateTime::createFromFormat('Y-m', $year . '-' . $month))
        {
            throw new E404Exception;
        }

        $provider = Story::getStoriesByTopic($year, $month, $topic);
          /*  (new ModelDataProvider(Story::class, [
                'where' => 'YEAR(published)=:year AND MONTH(published)=:month AND __topic_id=:topic',
                'order' => 'published DESC',
                'params' => [':year' => $year, ':month' => $month, ':topic' => $topic],
            ]));*/
        var_dump($provider);
        $this->data->provider = $provider;
        $this->data->page = $page;
        
        $this->data->year = $year;
        $this->data->month = $month;
    }


}
