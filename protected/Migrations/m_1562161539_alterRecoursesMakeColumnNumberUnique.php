<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1562161539_alterRecoursesMakeColumnNumberUnique
    extends Migration
{

    public function up()
    {
        $this->db->execute('CREATE UNIQUE INDEX recourses_number_uindex ON recourses (number);');
    }

    public function down()
    {
        $this->db->execute('DROP INDEX recourses_number_uindex ON recourses;');
    }
    
}