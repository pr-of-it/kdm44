<?php

namespace App\Dto\Validation\Validators;

use App\Dto\Validation\Exceptions\MinimalLengthException;
use App\Dto\Validation\Exceptions\NoDigitsException;
use Runn\Core\Exceptions;
use Runn\Validation\Exceptions\EmptyValue;
use Runn\Validation\Validator;

/**
 * Class MinimalLengthAndHasDigitsValidator
 * @package App\Dto\Validation\Validators
 */
class MinimalLengthAndHasDigitsValidator extends Validator
{
    protected const MINIMAL_LENGTH = 6;

    /**
     * @param mixed $value
     * @return bool
     * @throws Exceptions
     */
    public function validate($value): bool
    {
        $errors = new Exceptions();

        if (empty($value)) {
            $errors[] = new EmptyValue($value);
        } else {
            if (strlen($value) < static::MINIMAL_LENGTH) {
                $errors[] = new MinimalLengthException($value, static::MINIMAL_LENGTH);
            }

            if (1 !== preg_match('/\d/', $value)) {
                $errors[] = new NoDigitsException($value);
            }
        }

        if (!$errors->empty()) {
            throw $errors;
        }

        return true;
    }
}
