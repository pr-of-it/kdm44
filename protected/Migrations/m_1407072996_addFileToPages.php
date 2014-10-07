<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1407072996_addFileToPages
    extends Migration
{

    public function up()
    {
        $this->addColumn('pages', [
            'file' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('pages', 'file');
    }

}