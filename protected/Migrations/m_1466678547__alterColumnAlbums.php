<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1466678547__alterColumnAlbums
    extends Migration
{

    public function up()
    {
        $this->db->execute(<<<SQL
ALTER TABLE  `albums`
    CHANGE  `__cover_id`  `__cover_id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL;
SQL
        );
    }

    public function down()
    {
        return true;
    }

}