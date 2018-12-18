<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1545037003_addFullTextIndex
    extends Migration
{

    public function up()
    {
        $this->db->execute('CREATE FULLTEXT INDEX `newsstories_fulltext_idx` ON newsstories(`title`, `lead`, `text`);');
        $this->db->execute('CREATE FULLTEXT INDEX `pages_fulltext_idx` ON pages(`title`, `text`, `url`);');
        $this->db->execute('CREATE FULLTEXT INDEX `albums_fulltext_idx` ON albums(`title`, `url`);');
    }

    public function down()
    {
        $this->dropIndex('newsstories', 'newsstories_fulltext_idx');
        $this->dropIndex('pages', 'pages_fulltext_idx');
        $this->dropIndex('albums', 'albums_fulltext_idx');
    }
}
