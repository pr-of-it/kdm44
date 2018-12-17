<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1545037003_addFullTextIndex
    extends Migration
{

    public function up()
    {
        $this->db->execute('CREATE FULLTEXT INDEX `title_lead_text` ON newsstories(`title`, `lead`, `text`);');
        $this->db->execute('CREATE FULLTEXT INDEX `title_text_url` ON pages(`title`, `text`, `url`);');
        $this->db->execute('CREATE FULLTEXT INDEX `title_url` ON albums(`title`, `url`);');
    }

    public function down()
    {
        $this->dropIndex('newsstories', 'title_lead_text');
        $this->dropIndex('pages', 'title_text_url');
        $this->dropIndex('albums', 'title_url');
    }
    
}