<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1412680791_addPageFiles
    extends Migration
{

    public function up()
    {
        $this->dropColumn('pages', 'file');
        $this->createTable('pagefiles', [
            '__page_id' => ['type' => 'link'],
            'file' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropTable('pagefiles');
        $this->addColumn('pages', [
            'file' => ['type' => 'string'],
        ]);
    }

}