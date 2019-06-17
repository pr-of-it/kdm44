<?php

namespace App\Dto\UserUpdate;

use Runn\ValueObjects\ComplexValueObject;
use Runn\ValueObjects\Values\StringValue;

/**
 * ДТО для обновления пароля
 *
 * Class RequestDto
 * @package App\Dto\UserUpdate
 *
 * @property string $password
 * @property string $passwordConfirmation
 */
class RequestDto extends ComplexValueObject
{
    protected static $schema = [
        'password' => ['class' => StringValue::class, 'default' => null],
        'passwordConfirmation' => ['class' => StringValue::class, 'default' => null],
    ];
}
