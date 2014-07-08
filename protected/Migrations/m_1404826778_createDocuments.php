<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1404826778_createDocuments
    extends Migration
{

    public function up()
    {
        $this->createTable('document_cats',
            [
                'title' => [
                    'type' => 'string',
                ],
                'url' => [
                    'type' => 'string',
                ],
            ],
            [
                ['columns' => ['url']],
            ],
            ['tree']
        );
    }

    public function down()
    {
        $this->dropTable('document_cats');
    }

}