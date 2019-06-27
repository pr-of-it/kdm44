<?php

namespace App\Dto\UserUpdate;

use App\Dto\Values\PhoneNumber;
use Runn\ValueObjects\ComplexValueObject;
use Runn\ValueObjects\Values\StringValue;

/**
 * ДТО для обновления данных пользователя
 *
 * Class RequestDto
 * @package App\Dto\UserUpdate
 *
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property string $organization
 * @property string $phone
 * @property string $password
 * @property string $passwordConfirmation
 */
class RequestDto extends ComplexValueObject
{
    protected static $schema = [
        'firstName' => ['class' => StringValue::class],
        'lastName' => ['class' => StringValue::class],
        'middleName' => ['class' => StringValue::class, 'default' => null],
        'organization' => ['class' => StringValue::class, 'default' => null],
        'phone' => ['class' => PhoneNumber::class, 'default' => null],
        'password' => ['class' => StringValue::class, 'default' => null],
        'passwordConfirmation' => ['class' => StringValue::class, 'default' => null],
    ];
}
