<?php

namespace App\Dto\Values;

use App\Dto\Validation\Sanitizers\PhoneNumberSanitizer;
use App\Dto\Validation\Validators\PhoneNumberValidator;
use Runn\Sanitization\Sanitizer;
use Runn\Validation\Validator;
use Runn\ValueObjects\Values\StringValue;

class PhoneNumber extends StringValue
{
    protected function getDefaultValidator(): Validator
    {
        return new PhoneNumberValidator();
    }

    protected function getDefaultSanitizer(): Sanitizer
    {
        return new PhoneNumberSanitizer();
    }
}
