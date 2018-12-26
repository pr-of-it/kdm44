<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1545822990_fixPagesTreeColumns
    extends Migration
{

    public function up()
    {
        $this->db->execute('ALTER TABLE `pages` CHANGE `__prt` `__prt` BIGINT UNSIGNED NULL;');
    }

    public function down()
    {
        $this->db->execute('ALTER TABLE `pages` CHANGE `__prt` `__prt` BIGINT UNSIGNED NOT NULL DEFAULT 0;');
    }
}
