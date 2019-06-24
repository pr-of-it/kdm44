<?php

namespace App\Dto\UserRegister;

use App\Dto\Values\EmailOrNullValue;
use App\Dto\Values\PhoneNumber;
use Runn\ValueObjects\ComplexValueObject;
use Runn\ValueObjects\Values\BooleanValue;
use Runn\ValueObjects\Values\EmailValue;
use Runn\ValueObjects\Values\StringValue;

/**
 * ДТО для данных из формы регистрации
 *
 * Class UserRegisterData
 * @package App\Dto
 * @property string $email
 * @property string $password
 * @property string $firstName
 * @property string $middleName
 * @property string $lastName
 * @property string $organization
 * @property string $phone
 * @property integer $recipient
 * @property string $executive
 * @property string $emailConfirmation
 * @property string $passwordConfirmation
 * @property string $coauthorName
 * @property string $coauthorEmail
 * @property string $message
 * @property boolean $makePersonalAccount
 */
class RequestDto extends ComplexValueObject
{
    protected static $schema = [
        'email' => ['class' => EmailValue::class],
        'password' => ['class' => StringValue::class],
        'firstName' => ['class' => StringValue::class],
        'lastName' => ['class' => StringValue::class],
        'middleName' => ['class' => StringValue::class, 'default' => null],
        'organization' => ['class' => StringValue::class, 'default' => null],
        'phone' => ['class' => PhoneNumber::class, 'default' => null],

        'recipient' => ['class' => StringValue::class],
        'executive' => ['class' => StringValue::class, 'default' => null],
        'emailConfirmation' => ['class' => EmailValue::class],
        'passwordConfirmation' => ['class' => StringValue::class],

        'coauthorName' => ['class' => StringValue::class, 'default' => null],
        'coauthorEmail' => ['class' => EmailOrNullValue::class, 'default' => null],

        'message' => ['class' => StringValue::class],
        'makePersonalAccount' => ['class' => BooleanValue::class, 'default' => null],
    ];
}