<?php

namespace App\Dto\RecourseUpdate;

use Runn\ValueObjects\ComplexValueObject;
use Runn\ValueObjects\Values\StringValue;

/**
 * ДТО для обновления данных обращения
 *
 * Class RequestDto
 * @package App\Dto\RecourseUpdate
 *
 * @property string $type
 * @property string $status
 * @property string $number
 * @property string $comment
 */
class RequestDto extends ComplexValueObject
{
    protected static $schema = [
        'type' => ['class' => StringValue::class],
        'status' => ['class' => StringValue::class],
        'number' => ['class' => StringValue::class],
        'comment' => ['class' => StringValue::class, 'default' => null],
    ];
}
