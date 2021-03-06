<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1429201837_NewsImages extends Migration
{

    public function up()
    {
        $this->createTable('newsimages',
            ['path' => ['type' => 'string'],
             '__story_id' => ['type' => 'link']],
            ['story' => ['columns' => ['__story_id']]]);
    }

    public function down()
    {
        $this->dropTable('newsimages');
    }

}