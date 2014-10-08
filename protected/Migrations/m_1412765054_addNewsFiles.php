<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1412765054_addNewsFiles
    extends Migration
{

    public function up()
    {
        $this->createTable('newsfiles', [
            '__story_id' => ['type' => 'link'],
            'file' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropTable('newsfiles');
    }

}