<?php

namespace App\Exceptions;

use T4\Core\Exception;

/**
 * Исключение для конфликтных ситуаций
 *
 * Class ConflictException
 * @package App\Exceptions
 */
class ConflictException extends Exception
{
    protected $code = 409;
}