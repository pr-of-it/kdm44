<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1397044835_createUserRoles
    extends Migration
{

    public function up()
    {
        $this->createTable('roles', [
            'name' => ['type'=>'string'],
            'title' => ['type'=>'string'],
        ], [
            ['columns' => ['name']]
        ]);
        $this->addColumn('__users', [
            '__role_id' => ['type'=>'link']
        ]);
        $this->addIndex('__users', [
            'role'=>['columns'=>['__role_id']]
        ]);
    }

    public function down()
    {
        $this->dropColumn('__users', '__role_id');
        $this->dropTable('roles');
    }

}