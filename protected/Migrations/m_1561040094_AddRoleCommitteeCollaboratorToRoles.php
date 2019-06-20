<?php

namespace App\Migrations;

use App\Models\Role;
use T4\Orm\Migration;

/**
 * Class m_1561040094_AddRoleCommitteeCollaboratorToRoles
 * @package App\Migrations
 */
class m_1561040094_AddRoleCommitteeCollaboratorToRoles
    extends Migration
{
    public function up()
    {
        $this->db->execute('INSERT INTO `roles` (`name`, `title`) VALUES (\'committeeCollaborator\', \'Committee collaborator\')');
    }

    public function down()
    {
        Role::findByColumn('name', 'committeeCollaborator')->delete();
    }
}
