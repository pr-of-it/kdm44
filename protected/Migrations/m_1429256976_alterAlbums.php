<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1429256976_alterAlbums
    extends Migration
{

    public function up()
    {
        $this->renameColumn('albums', '__photo_id', '__cover_id');
        $this->dropIndex('albums', 'cover');
        $this->addIndex('albums', [
            'cover' => ['columns' => ['__cover_id']]
        ]);
    }

    public function down()
    {
        $this->renameColumn('albums', '__cover_id', '__photo_id');
        $this->dropIndex('albums', 'cover');
        $this->addIndex('albums', [
            'cover' => ['columns' => ['__photo_id']]
        ]);
    }
}