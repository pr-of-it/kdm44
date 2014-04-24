<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1398340245_alterNewsStoriesTable
    extends Migration
{

    public function up()
    {
        $this->renameColumn('newsstories', '__newstopic_id', '__topic_id');
    }

    public function down()
    {
        $this->renameColumn('newsstories', '__topic_id', '__newstopic_id');
    }

}