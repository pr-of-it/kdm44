<?php

namespace App\Migrations;

use T4\Orm\Migration;

/**
 * Class m_1559748948_AlterUsersAddColumns
 * @package App\Migrations
 */
class m_1559748948_AlterUsersAddColumns
    extends Migration
{

    public function up()
    {
        $this->addColumn('__users', [
            'first_name' => ['type'=>'string'],
            'name' => ['type'=>'string'],
            'father_name' => ['type'=>'string'],
            'organization' => ['type'=>'string'],
            'phone' => ['type'=>'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('__users', [
            'first_name',
            'name',
            'father_name',
            'organization',
            'phone'
        ]);
    }
}
