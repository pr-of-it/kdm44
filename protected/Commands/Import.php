<?php

namespace App\Commands;

use App\Modules\News\Models\Story;
use App\Modules\News\Models\Topic;
use App\Modules\Pages\Models\Page;
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

        $processed = [];

        $connection = Topic::getDbConnection();
        $sql = 'INSERT INTO `' . Topic::getTableName() . '` (`__id`, `title`) VALUES (:id, :title)';

        while ($row = fgetcsv($dataFile, 0, ',', '"', '"')) {
            $connection->execute($sql, [':id' => $row[0], ':title' => $row[3]]);
            $processed[$row[0]] = ['pk'=>$row[0]];
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

        $sql = 'INSERT INTO `' . Story::getTableName() . '` (`__id`, `title`, `published`, `lead`, `image`, `text`, `__topic_id`) VALUES (:id, :title, :published, :lead, :image, :text, :topic)';

        while ($row = fgetcsv($dataFile, 0, ',', '"', '"')) {

            $lead = $row[9];
            preg_match('~\<img(.+?)src="(.+?)"(.*?)[\/]?\>~', $lead, $m);
            if (!empty($m[2])) {
                $image = $m[2];
                $lead = str_replace($m[0], '', $lead);
            } else {
                $image = '';
            }

            $connection->execute($sql, [
                ':id' => $row[0],
                ':title' => $row[2],
                ':published' => date('Y-m-d H:i:s', $row[4]),
                ':lead' => $lead,
                ':image' => $image,
                ':text' => $row[10],
                ':topic' => $topics[$row[12]]['pk'],
            ]);

        }

    }

    public function actionPages()
    {
        $dataFileName = realpath(__DIR__ . DS . '..' . DS . '..' . DS . 'data' . DS . 'kdm3_pages_pages.csv');
        if (!is_readable($dataFileName))
            throw new Exception('Data file ' . $dataFileName . ' is not found or is not readable');
        $dataFile = fopen($dataFileName, 'r');

        $deferred = [];
        $processed = [];

        while ($row = fgetcsv($dataFile, 0, ',', '"', '"')) {

            // Если родительский объект имеется и его еще нет среди обработанных - отложим
            if ($row[1] != 0 && !isset($processed[$row[1]])) {
                $deferred[] = $row;
                continue;
            }

            $item = new Page();
            $item->title = $row[2];
            $item->url = $row[3];
            $item->template = $row[4];
            $item->text = $row[5];
            $item->order = $row[9];
            $item->parent =  0==$row[1] ? 0 : $processed[$row[1]];
            $item->save();

            $processed[$row[0]] = $item->getPk();

        }

        while (!empty($deferred)) {
            foreach ($deferred as $id => $row) {
                // Если родительский объект имеется и его еще нет среди обработанных - отложим
                if ($row[1] != 0 && !isset($processed[$row[1]])) {
                    $deferred[] = $row;
                    continue;
                }

                $item = new Page();
                $item->title = $row[2];
                $item->url = $row[3];
                $item->template = $row[4];
                $item->text = $row[5];
                $item->order = $row[9];
                $item->parent = 0==$row[1] ? 0 : $processed[$row[1]];
                $item->save();

                $processed[$row[0]] = $item->getPk();
                unset($deferred[$id]);
            }
        }

    }

}