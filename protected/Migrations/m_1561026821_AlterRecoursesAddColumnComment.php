<?php

namespace App\Migrations;

use T4\Orm\Migration;

/**
 * Class m_1561026821_AlterRecoursesAddColumnComment
 * @package App\Migrations
 */
class m_1561026821_AlterRecoursesAddColumnComment
    extends Migration
{

    public function up()
    {
        $this->addColumn('recourses', [
            'comment' => ['type'=>'text', 'length' => 'big'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('recourses', [
            'comment'
        ]);
    }
}
