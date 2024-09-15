<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1500376939_AlbumsPrtTrigger
    extends Migration
{

    public function up()
    {
        $this->db->execute(<<<SQL
CREATE TRIGGER insert_albums_prt
BEFORE INSERT ON albums
FOR EACH ROW
  SET NEW.`__prt` = IFNULL(NEW.`__prt`, 0);
SQL
        );
    }

    public function down()
    {
        $this->db->execute(<<<SQL
DROP TRIGGER insert_albums_prt;
SQL
        );
    }
}
