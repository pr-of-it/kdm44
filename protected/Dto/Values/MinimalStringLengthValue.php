<?php

namespace App\Dto\Values;

use App\Dto\Validation\Validators\MinimalLengthAndHasDigitsValidator;
use Runn\ValueObjects\Values\StringValue;
use Runn\Validation\Validator;

/**
 * Class MinimalStringLengthValue
 * @package App\Http\Dto\V1\Values
 */
class MinimalStringLengthValue extends StringValue
{
    /**
     * @return Validator
     */
    protected function getDefaultValidator(): Validator
    {
        return new MinimalLengthAndHasDigitsValidator();
    }
}
