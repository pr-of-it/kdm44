<?php

namespace App\Dto\UserLogin;

use Runn\ValueObjects\ComplexValueObject;
use Runn\ValueObjects\Values\EmailValue;
use Runn\ValueObjects\Values\StringValue;

/**
 * ДТО для данных из формы входа
 *
 * Class RequestDto
 * @package App\Dto\UserLogin
 * @property string $email
 * @property string $password
 */
class RequestDto extends ComplexValueObject
{
    protected static $schema = [
        'email' => ['class' => EmailValue::class],
        'password' => ['class' => StringValue::class],
    ];
}
