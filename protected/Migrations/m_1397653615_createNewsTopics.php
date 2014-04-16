<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1397653615_createNewsTopics
    extends Migration
{

    public function up()
    {
        $this->createTable('newstopics', [
            'title' => ['type'=>'string']
        ], [

        ], [
            'tree'
        ]);
    }

    public function down()
    {
        $this->dropTable('newstopics');
    }

}