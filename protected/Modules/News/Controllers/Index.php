<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionStory($id)
    {
        $this->data->item = Story::findByPK($id);
        // TODO: исключить саму новость из списка похожих!
        $this->data->similar = Story::findAllByColumn(
            '__topic_id', $this->data->item->topic->getPk(),
            [
                'order' => 'published DESC',
                'limit' => 5,
            ]
        );
    }

    public function actionNewsByTopic($id, $count=20)
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
    }

}