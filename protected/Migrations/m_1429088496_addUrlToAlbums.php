<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1429088496_addUrlToAlbums
    extends Migration
{

    public function up()
    {
        $this->addColumn('albums', [
            'url' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('albums', 'url');
    }

}