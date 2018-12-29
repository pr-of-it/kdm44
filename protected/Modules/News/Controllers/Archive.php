<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Http\E404Exception;
use T4\Mvc\Controller;
use T4\Orm\ModelDataProvider;

/**
 * Class Archive
 * @package App\Modules\News\Controllers
 */
class Archive
    extends Controller
{
    public function actionDefault()
    {
        $this->data->items = Story::getItemsCountGroupByYears();
    }

    /**
     * @param null $year
     * @throws E404Exception
     */
    public function actionNewsByMonth($year = null)
    {
        if (false === \DateTime::createFromFormat('Y', $year)) {
            throw new E404Exception;
        }

        $this->data->items = Story::getItemsCountGroupByMonths($year);
        $this->data->year = $year;
    }

    /**
     * @param null $year
     * @param null $month
     * @throws E404Exception
     */
    public function actionNewsByTopic($year = null, $month = null)
    {
        if (0 >= $month || 12 < $month || 0 >= $year
            || false === \DateTime::createFromFormat('Y-m', $year . '-' . $month)) {
            throw new E404Exception;
        }

        $this->data->topics = Story::getItemsCountGroupByTopic($year, $month);

        $this->data->year = $year;
        $this->data->month = $month;
    }

    /**
     * @param null $year
     * @param null $month
     * @param null $topic
     * @param int $page
     * @throws E404Exception
     * @throws \T4\Orm\Exception
     */
    public function actionNewsByDay($year = null, $month = null, $topic = null, $page = 1)
    {
        if (!is_numeric($topic)) {
            throw new E404Exception;
        }
        if (!is_numeric($page)) {
            throw new E404Exception;
        }
        if (0 >= $month || 12 < $month || 0 >= $year || 0 > $topic || 0 >= $page
            || false === \DateTime::createFromFormat('Y-m', $year . '-' . $month)) {
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
