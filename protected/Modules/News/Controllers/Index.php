<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\NewsStory;
use App\Modules\News\Models\NewsTopic;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionStory($id)
    {
        $this->data->item = NewsStory::findByPK($id);
        // TODO: исключить саму новость из списка похожих!
        $this->data->similar = NewsStory::findAllByColumn(
            '__newstopic_id', $this->data->item->topic->getPk(),
            [
                'order' => 'published DESC',
                'limit' => 5,
            ]
        );
    }

    public function actionNewsByTopic($id, $count=20)
    {
        $this->data->topic = NewsTopic::findByPK($id);
        $this->data->items = NewsStory::findAllByColumn(
            '__newstopic_id',
            $id,
            [
                'order' => 'published DESC',
                'limit' => $count,
            ]
        );
    }

}