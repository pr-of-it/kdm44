<?php

namespace App\Migrations;

use App\Models\Role;
use App\Models\User;
use T4\Orm\Migration;

/**
 * Class m_1561384354_AddUserWithCommitteeCollaboratorToUsers
 * @package App\Migrations
 */
class m_1561384354_AddUserWithCommitteeCollaboratorToUsers
    extends Migration
{
    public function up()
    {
        $role = Role::findByColumn('name', 'committeeCollaborator');
        $this->db->execute('INSERT INTO `__users` 
        (`email`, 
        `password`,
        `first_name`,
        `middle_name`,
        `last_name`,
        `__role_id`)
         VALUES 
         (\'info@kdm44.ru\',
         \'' . password_hash(123456, PASSWORD_DEFAULT) . '\',
         \'Виноградова\',
         \'Христина\',
         \'Александровна\',
         \'' . $role->getPk() . '\'
         )');
    }

    public function down()
    {
        User::findByColumn('email', 'info@kdm44.ru')->delete();
    }
}
