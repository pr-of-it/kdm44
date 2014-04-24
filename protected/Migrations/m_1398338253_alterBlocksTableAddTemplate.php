<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1398338253_alterBlocksTableAddTemplate
    extends Migration
{

    public function up()
    {
        $this->addColumn('__blocks', [
            'template' => ['type'=>'string']
        ]);
    }

    public function down()
    {
        $this->dropColumn('__blocks', 'template');
    }

}