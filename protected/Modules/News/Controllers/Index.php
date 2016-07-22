<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    const DEFAULT_STORIES_COUNT = 20;

    public function actionDefault($count = self::DEFAULT_STORIES_COUNT)
    {
        $this->data->topics = Topic::findAllTree();
        $this->data->items = Story::findAll(
            [
                'order' => 'published DESC',
                'limit' => $count,
            ]
        );
    }

    public function actionStory($id)
    {
        $this->data->item = Story::findByPK($id);
        if (empty($this->data->item)) {
            throw new E404Exception;
        }
        $this->data->similar = Story::findAllByColumn(
            '__topic_id', $this->data->item->topic->getPk(),
            [
                'order' => 'published DESC',
                'limit' => 5,
                'where' => 't1.__id <> ' . $this->data->item->getPk(),
            ]
        );
        $this->view->meta->title = $this->data->item->title;
    }

    public function actionNewsByTopic($id, $count = self::DEFAULT_STORIES_COUNT, $color = 'default')
    {
        $this->data->topic = Topic::findByPK($id);
        if (empty($this->data->topic)) {
            throw new E404Exception;
        }

        $this->data->page = $this->app->request->get->page ?: 1;
        $this->data->total = Story::countAllByColumn('__topic_id', $this->data->topic->getPk());
        $this->data->size = $count;

        $this->data->items = Story::findAllByColumn(
            '__topic_id',
            $this->data->topic->getPk(),
            [
                'order' => 'published DESC',
                'offset' => ($this->data->page - 1) * $count,
                'limit' => $count,
            ]
        );

        $this->data->color = $color;

        $this->view->meta->title = $this->data->topic->title;
    }

    public function actionArchives()
    {
        $this->data->items = Story::getYears();
    }

    public function actionArchive($year)
    {
        $this->data->year = $year;
        $this->data->page = $this->app->request->get->page ?: 1;
        $count = self::DEFAULT_STORIES_COUNT;
        $this->data->size = $count;
        $this->data->total = Story::countAllByDate($year);
        $this->data->items = Story::findAll(
            [
                'order' => 'published DESC',
                'offset' => ($this->data->page - 1) * $count,
                'limit' => $count,
                'where' => 'YEAR(published) = :year',
                'params' => [':year' => $year],
            ]
        );
    }

    public function actionArchiveByMonth($year, $month, $count = self::DEFAULT_STORIES_COUNT)
    {
        $this->data->monthnum = $month;
        $this->data->year = $year;
        $this->data->page = $this->app->request->get->page ?: 1;
        $this->data->size = $count;
        $this->data->total = Story::countAllByDate($year, $month);
        $this->data->topics = Topic::findAllTree();
        $this->data->items = Story::findAll(
            [
                'offset' => ($this->data->page - 1) * $count,
                'limit' => $count,
                'where' => 'YEAR(published) = :year AND MONTH(published) = :month',
                'params' => [':year' => $year, ':month' => $month],
            ]
        );
    }

    public function actionArchiveMonthByTopic($year, $month, $id, $count = self::DEFAULT_STORIES_COUNT, $color = 'default')
    {
        $this->data->topic = Topic::findByPK($id);
        if (empty($this->data->topic)) {
            throw new E404Exception;
        }
        $this->data->page = $this->app->request->get->page ?: 1;
        $column = '__topic_id';
        $this->data->value = $this->data->topic->getPk();
        $this->data->total = Story::countAllByDateColumn($column, $this->data->value, $year, $month);
        $this->data->size = $count;
        $this->data->items = Story::findAllByColumn('__topic_id',
            $this->data->topic->getPk(),
            [
                'offset' => ($this->data->page - 1) * $count,
                'limit' => $count,
                'where' => 'YEAR(published) = ' . $year . ' AND MONTH(published) = ' . $month,
            ]
        );
        $this->data->year = $year;
        $this->data->color = $color;
        $this->data->monthnum = $month;
        $this->view->meta->title = $this->data->topic->title;
    }
}