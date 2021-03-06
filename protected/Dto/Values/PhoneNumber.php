<?php

namespace App\Dto\Values;

use App\Dto\Validation\Sanitizers\PhoneNumberSanitizer;
use App\Dto\Validation\Validators\PhoneNumberValidator;
use Runn\Sanitization\Sanitizer;
use Runn\Validation\Validator;
use Runn\ValueObjects\Values\StringValue;

/**
 * Class PhoneNumber
 * @package App\Dto\Values
 */
class PhoneNumber extends StringValue
{
    /**
     * @return Validator
     */
    protected function getDefaultValidator(): Validator
    {
        return new PhoneNumberValidator();
    }

    /**
     * @return Sanitizer
     */
    protected function getDefaultSanitizer(): Sanitizer
    {
        return new PhoneNumberSanitizer();
    }
}
