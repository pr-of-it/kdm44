<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Class Recourse
 * @package App\Models
 */
class Recourse
    extends Model
{
    public $status =
        [
            'new' => 'new',
            'registered' => 'registered',
            'withAnswer' => 'withAnswer',
        ];

    public static $schema = [
        'table' => 'recourses',
        'columns' => [
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
            'status'        => ['type'=>'string'],
            'number'        => ['type'=>'string'],
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
    public function setFieldsByRequest(array $data): void
    {
        $this->type = $data['type'];
        $this->recipient = '3' !== $data['recipient'] ?
            $data['recipient'] : 'Должностное лицо комитета по делам молодёжи: ' . $data['executive'];
        $this->email = $data['email'];
        $this->first_name = $data['firstName'];
        $this->middle_name = $data['middleName'];
        $this->last_name = $data['lastName'];
        $this->organization = $data['organization'];
        $this->phone = $data['phone'];
        $this->coauthor_name = $data['coauthorName'];
        $this->coauthor_email = $data['coauthorEmail'];
        $this->message = $data['message'];
        $this->file1 = $data['customFile']['name'];
        $this->file2 = $data['customFile2']['name'];
        $this->status = $this->status['new'];

        $user = User::findByColumn('email', $data['email']);

        $this->user = false !== $user ? $user->getPk() : null;
    }
}
