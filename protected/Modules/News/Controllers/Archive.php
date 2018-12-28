<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
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

    /**
     * @param int|null $year
     * @param int|null $month
     * @throws E404Exception
     */
    public function actionNewsByTopic(int $year = null, int $month = null)
    {
        if (0 >= $month || 12 < $month || 0 >= $year
            || null === \DateTime::createFromFormat('Y-m', $year . '-' . $month)) {
            throw new E404Exception;
        }

        $this->data->topics = Story::getItemsCountGroupByTopic($year, $month);

        $this->data->year = $year;
        $this->data->month = $month;
    }

    /**
     * @param int|null $year
     * @param int|null $month
     * @param int|null $topic
     * @param int $page
     * @throws E404Exception
     * @throws \T4\Orm\Exception
     */
    public function actionNewsByDay(int $year = null, int $month = null, int $topic = null, int $page = 1)
    {
        if (0 >= $month || 12 < $month || 0 >= $year
            || null === \DateTime::createFromFormat('Y-m', $year . '-' . $month)) {
            throw new E404Exception;
        }

        $provider =
            (new ModelDataProvider(Story::class, [
                'where' => 'YEAR(published)=:year AND MONTH(published)=:month AND `__topic_id`=:topic',
                'order' => 'published DESC',
                'params' => [':year' => $year, ':month' => $month, ':topic' => $topic],
            ]));

        $this->data->topic = Topic::findByPK($topic);

        $this->data->provider = $provider;
        $this->data->page = $page;
        
        $this->data->year = $year;
        $this->data->month = $month;
    }
}
