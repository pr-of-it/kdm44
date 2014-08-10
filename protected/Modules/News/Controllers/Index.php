<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    const DEFAULT_STORIES_COUNT = 20;

    public function actionDefault($count=self::DEFAULT_STORIES_COUNT)
    {
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
        $this->data->similar = Story::findAllByColumn(
            '__topic_id', $this->data->item->topic->getPk(),
            [
                'order' => 'published DESC',
                'limit' => 5,
                'where' => 't1.__id <> ' . $id,
            ]
        );
    }

    public function actionNewsByTopic($id, $count=self::DEFAULT_STORIES_COUNT, $color='default')
    {
        $this->data->topic = Topic::findByPK($id);
        $this->data->items = Story::findAllByColumn(
            '__topic_id',
            $id,
            [
                'order' => 'published DESC',
                'limit' => $count,
            ]
        );
        $this->data->color = $color;
    }

}