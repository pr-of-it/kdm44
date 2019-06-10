<?php

namespace App\Dto\Values;

use App\Dto\Validation\Validators\EmailOrNullValidator;
use Runn\Sanitization\Sanitizer;
use Runn\Sanitization\Sanitizers\EmailSanitizer;
use Runn\Validation\Validator;
use Runn\ValueObjects\Values\EmailValue;

class EmailOrNullValue extends EmailValue
{
    /**
     * @return \Runn\Validation\Validator
     */
    protected function getDefaultValidator(): Validator
    {
        return new EmailOrNullValidator();
    }

    /**
     * @return \Runn\Sanitization\Sanitizer
     */
    protected function getDefaultSanitizer(): Sanitizer
    {
        return new EmailSanitizer();
    }
}
