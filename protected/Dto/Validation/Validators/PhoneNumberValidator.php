<?php

namespace App\Dto\Validation\Validators;

use App\Dto\Validation\Exceptions\InvalidPhone;
use Runn\Validation\Validator;

/**
 * Class PhoneNumberValidator
 * @package App\Http\DtoValidation\Validators
 */
class PhoneNumberValidator extends Validator
{
    /**
     * @param mixed $value
     * @return bool
     * @throws InvalidPhone
     */
    public function validate($value): bool
    {
        if (!empty($value)) {
            if (11 !== preg_match_all('/\d/', (string)$value)) {
                throw new InvalidPhone($value);
            }
        }

        return true;
    }
}
