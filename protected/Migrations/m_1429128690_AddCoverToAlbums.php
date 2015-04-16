<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1429128690_AddCoverToAlbums
    extends Migration
{

    public function up()
    {
        $this->addColumn('albums', [
            '__photo_id' => ['type' => 'link'],
        ]);
        $this->addIndex('albums', [
            'cover' => ['columns' => ['__photo_id']]
        ]);
    }

    public function down()
    {
        $this->dropColumn('albums', '__photo_id');
    }
}