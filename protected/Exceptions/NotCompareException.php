<?php

namespace App\Exceptions;

use T4\Core\Exception;

/**
 * Исключение для несовпадающих значений
 *
 * Class ConflictException
 * @package App\Exceptions
 */
class NotCompareException extends Exception
{
    protected $code = 400;
}