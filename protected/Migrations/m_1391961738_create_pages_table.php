<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1391961738_create_pages_table
    extends Migration
{

    public function up()
    {
        $this->createTable('pages',
            [
                'title' => [
                    'type' => 'string',
                ],
                'url' => [
                    'type' => 'string',
                ],
                'text' => [
                    'type' => 'text',
                    'length' => 'big',
                ],
                'order' => [
                    'type' => 'int'
                ]
            ],
            [
                ['columns' => ['url']],
                ['columns' => ['order']]
            ],
            ['tree']
        );
    }

    public function down()
    {
        $this->dropTable('pages');
    }

}