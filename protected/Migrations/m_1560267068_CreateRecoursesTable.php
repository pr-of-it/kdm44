<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1560267068_CreateRecoursesTable
    extends Migration
{

    public function up()
    {
        $this->createTable('recourses', [
            'type'          => ['type'=>'string'],
            'recipient'     => ['type'=>'string'],
            'email'         => ['type'=>'string'],
            'first_name'    => ['type'=>'string'],
            'middle_name'   => ['type'=>'string'],
            'last_name'     => ['type'=>'string'],
            'organization'  => ['type'=>'string'],
            'phone'         => ['type'=>'string'],
            'coauthor_name' => ['type'=>'string'],
            'coauthor_email'=> ['type'=>'string'],
            'message'       => ['type'=>'string'],
            'file1'         => ['type'=>'string'],
            'file2'         => ['type'=>'string'],
            '__user_id'     => ['type'=>'link'],
            'created_at'    => ['type' => 'timestamp'],
        ], [
            'user'=>['columns'=>['__user_id']]
        ]);
    }

    public function down()
    {
        $this->dropTable('recourses');
    }
}
