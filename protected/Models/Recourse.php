<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Обращения граждан в электронную приемную
 *
 * Class Recourse
 * @package App\Models
 */
class Recourse
    extends Model
{
    public const TYPES_RUS = [
        'send' => 'Письмо',
        'corruption' => 'Сообщение о коррупции',
        'collective-send' => 'Коллективное письмо',
    ];

    public const STATUSES_RUS = [
        'new' => 'Новое',
        'registered' => 'Зарегистрировано',
        'withAnswer' => 'Дан ответ',
    ];

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
            'comment'       => ['type'=>'string'],
            'created_at'    => ['type' => 'timestamp'],
        ],
        'relations' => [
            'user' => ['type' => self::BELONGS_TO, 'model' => User::class]
        ],
    ];

    /**
     * Русское значение поля "тип обращения"
     * @return string
     */
    public function getTypeRus(): string
    {
        return self::TYPES_RUS[$this->type] ?? $this->type;
    }

    /**
     * Русское значение поля "статус обращения"
     * @return string
     */
    public function getStatusRus(): string
    {
        return self::STATUSES_RUS[$this->status] ?? $this->status;
    }

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
        $this->status = $this->status['new'];

        $user = User::findByColumn('email', $data['email']);

        $this->user = false !== $user ? $user->getPk() : null;
    }
}
