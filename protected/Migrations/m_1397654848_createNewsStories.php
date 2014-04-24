<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1397654848_createNewsStories
    extends Migration
{

    public function up()
    {
        $this->createTable('newsstories', [
            'title' => ['type'=>'string', 'length' => 1024],
            'published' => ['type'=>'datetime'],
            'lead' => ['type'=>'text'],
            'text' => ['type'=>'text'],
            '__newstopic_id' => ['type'=>'link'],
        ], [
            'topic'=>['columns'=>['__newstopic_id']]
        ]);
    }

    public function down()
    {
        $this->dropTable('newsstories');
    }

}