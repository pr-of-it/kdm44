<?php

namespace App\Migrations;

use App\Models\Role;
use T4\Orm\Migration;

/**
 * Class m_1559914777_AddRoleUserToRoles
 * @package App\Migrations
 */
class m_1559914777_AddRoleUserToRoles
    extends Migration
{

    public function up()
    {
        $this->db->execute('INSERT INTO `roles` (`name`, `title`) VALUES (\'user\', \'User\')');
    }

    public function down()
    {
        Role::findByColumn('name', 'user')->delete();
    }
    
}