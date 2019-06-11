<?php

namespace App\Dto\Validation\Exceptions;

use Runn\Html\Form\Field;
use Runn\Validation\ValidationError;

/**
 * Class CompareException
 * @package App\Dto\Validation\Exceptions
 */
class CompareException extends ValidationError
{
    public $compareField;

    public function __construct($value = null, Field $field = null, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($value, $message, $code, $previous);
        $this->compareField = $field;
    }

}
