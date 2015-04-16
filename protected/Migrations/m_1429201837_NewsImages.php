<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1429201837_NewsImages extends Migration
{

    public function up()
    {
        $this->createTable('NewsImages',['image'=>['type'=>'string'],
                                         '__news_id'=>['type'=>'link']],
                                         ['topic'=>['columns'=>['__news_id']]]);
    }

    public function down()
    {
        $this->dropTable('NewsImages');
    }

}