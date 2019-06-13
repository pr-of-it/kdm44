<?php

namespace App\Dto\Validation\Sanitizers;

use Runn\Sanitization\Sanitizer;

/**
 * Class PhoneNumberSanitizer
 * @package App\Dto\Validation\Sanitizers
 */
class PhoneNumberSanitizer extends Sanitizer
{
    /**
     * @param mixed $value
     * @return string
     */
    public function sanitize($value): string
    {
        return preg_replace(['/^\D*8/', '/\D/'], ['7', ''], (string)$value);
    }
}