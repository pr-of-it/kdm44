<?php

namespace App\Migrations;

use T4\Orm\Migration;

/**
 * Class m_1560951663_AlterRecoursesAddColumns
 * @package App\Migrations
 */
class m_1560951663_AlterRecoursesAddColumns
    extends Migration
{

    public function up()
    {
        $this->addColumn('recourses', [
            'status' => ['type'=>'string'],
            'number' => ['type'=>'string']
        ]);
    }

    public function down()
    {
        $this->dropColumn('recourses', [
            'status',
            'number'
        ]);
    }
}
