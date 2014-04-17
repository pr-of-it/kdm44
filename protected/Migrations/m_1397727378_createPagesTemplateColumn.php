<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1397727378_createPagesTemplateColumn
    extends Migration
{

    public function up()
    {
        $this->addColumn('pages', [
            'template' => ['type'=>'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('pages', 'template');
    }

}