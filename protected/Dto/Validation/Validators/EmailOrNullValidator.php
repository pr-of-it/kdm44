<?php

namespace App\Dto\Validation\Validators;

use Runn\Validation\Exceptions\InvalidEmail;
use Runn\Validation\Validator;

/**
 * Class EmailOrNullValidator
 * @package App\Dto\Validation\Validators
 */
class EmailOrNullValidator extends Validator
{
    /**
     * @param mixed $value
     * @return bool
     * @throws InvalidEmail
     */
    public function validate($value): bool
    {
        if (!empty($value)) {
            if ( false === filter_var($value, \FILTER_VALIDATE_EMAIL) ) {
                throw new InvalidEmail($value);
            }
        }

        return true;
    }
}
