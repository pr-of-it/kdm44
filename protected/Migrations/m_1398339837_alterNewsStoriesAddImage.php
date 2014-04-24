<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1398339837_alterNewsStoriesAddImage
    extends Migration
{

    public function up()
    {
        $this->addColumn('newsstories', [
            'image' => ['type'=>'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('newsstories', 'image');
    }

}