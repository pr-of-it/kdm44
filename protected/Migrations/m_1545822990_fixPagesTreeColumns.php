<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1545822990_fixPagesTreeColumns
    extends Migration
{

    public function up()
    {
        $this->db->execute('ALTER TABLE `pages` CHANGE `__prt` `__prt` BIGINT UNSIGNED NULL;');
        $this->db->execute('UPDATE `pages` set `__prt`= NULL WHERE `__prt` = 0;');
    }

    public function down()
    {
        $this->db->execute('UPDATE `pages` set `__prt`= 0 WHERE `__prt` IS NULL;');
        $this->db->execute('ALTER TABLE `pages` CHANGE `__prt` `__prt` BIGINT UNSIGNED NOT NULL DEFAULT 0;');
    }
}
