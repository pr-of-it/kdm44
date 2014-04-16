<?php

namespace App\Commands;

use App\Modules\News\Models\NewsStory;
use App\Modules\News\Models\NewsTopic;
use T4\Console\Command;
use T4\Console\Exception;

class Import
    extends Command
{

    public function actionNews()
    {

        /*
         * NEWS TOPICS
         */
        $dataFileName = realpath(__DIR__ . DS . '..' . DS . '..' . DS . 'data' . DS . 'kdm3_news_topics.csv');
        if (!is_readable($dataFileName))
            throw new Exception('Data file ' . $dataFileName . ' is not found or is not readable');
        $dataFile = fopen($dataFileName, 'r');

        $deferred = [];
        $processed = [];

        while ($row = fgetcsv($dataFile, 0, ',', '"', '"')) {

            // Если родительский объект имеется и его еще нет среди обработанных - отложим
            if ($row[1] != 0 && !isset($processed[$row[1]])) {
                $deferred[] = $item;
                continue;
            }
            $item = new NewsTopic();
            $item->title = $row[3];
            $item->setParent(0);
            $item->save();
            $processed[$row[0]] = ['pk'=>$item->getPk()];
        }

        $topics = $processed;
        // TODO: цикл обработки $deferred

        /*
         * NEWS ARTICLES
         */

        $dataFileName = realpath(__DIR__ . DS . '..' . DS . '..' . DS . 'data' . DS . 'kdm3_news_stories.csv');
        if (!is_readable($dataFileName))
            throw new Exception('Data file ' . $dataFileName . ' is not found or is not readable');
        $dataFile = fopen($dataFileName, 'r');

        while ($row = fgetcsv($dataFile, 0, ',', '"', '"')) {
            $item = new NewsStory();
            $item->title = $row[2];
            $item->published = date('Y-m-d H:i:s', $row[4]);
            $item->lead = $row[9];
            $item->text = $row[10];
            $item->__newstopic_id = $topics[$row[12]]['pk'];
            $item->save();
        }

    }

}