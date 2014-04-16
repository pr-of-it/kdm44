<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\NewsStory;
use App\Modules\News\Models\NewsTopic;
use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionNewsByTopic($id)
    {
        $this->data->topic = NewsTopic::findByPK($id);
        $this->data->items = NewsStory::findAllByColumn(
            '__newstopic_id',
            $id,
            [
                'order' => 'published DESC',
                'limit' => 5,
            ]
        );
    }

}