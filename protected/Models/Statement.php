<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Class Statement
 * @package App\Models
 */
class Statement
    extends Model
{
    public static $schema = [
        'table' => 'statements',
        'columns' => [
            'type'          => ['type'=>'string'],
            'recipient'     => ['type'=>'string'],
            'email'         => ['type'=>'string'],
            'first_name'    => ['type'=>'string'],
            'name'          => ['type'=>'string'],
            'father_name'   => ['type'=>'string'],
            'organization'  => ['type'=>'string'],
            'phone'         => ['type'=>'string'],
            'coauthor_name' => ['type'=>'string'],
            'coauthor_email'=> ['type'=>'string'],
            'message'       => ['type'=>'string'],
            'file1'         => ['type'=>'string'],
            'file2'         => ['type'=>'string'],
            'created_at'    => ['type' => 'timestamp'],
        ],
        'relations' => [
            'user'=>['type'=>self::BELONGS_TO, 'model'=>\App\Models\User::class]
        ],
    ];

    /**
     * @param array $data
     * @throws \Exception
     */
    public function setFillByRequest(array $data): void
    {
        $this->type = $data['type'];
        $this->recipient = '3' !== $data['recipient'] ?
            $data['recipient'] : 'Должностному лицу комитета по делам молодёжи: ' . $data['executive'];
        $this->email = $data['email'];
        $this->first_name = $data['firstName'];
        $this->name = $data['name'];
        $this->father_name = $data['fatherName'];
        $this->organization = $data['organization'];
        $this->phone = $data['phone'];
        $this->coauthor_name = $data['coauthorName'];
        $this->coauthor_email = $data['coauthorEmail'];
        $this->message = $data['message'];
        $this->file1 = $data['customFile']['name'];
        $this->file2 = $data['customFile2']['name'];

        $user = User::findByColumn('email', $data['email']);

        $this->user = false !== $user ? $user->getPk() : null;
    }
}
