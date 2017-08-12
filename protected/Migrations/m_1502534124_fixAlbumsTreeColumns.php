<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1502534124_fixAlbumsTreeColumns
    extends Migration
{

    public function up()
    {
        $this->db->execute('ALTER TABLE `albums` CHANGE `__prt` `__prt` BIGINT NULL DEFAULT NULL;');
    }

    public function down()
    {
    }
    
}