<?php

namespace App\Dto\Validation\Validators;

use App\Dto\Validation\Exceptions\MinimalLengthException;
use App\Dto\Validation\Exceptions\NoDigitsException;
use Runn\Core\Exceptions;
use Runn\Html\Form\Field;
use Runn\Validation\Exceptions\EmptyValue;
use Runn\Validation\Validator;

/**
 * Class MinimalLengthAndHasDigitsValidator
 * @package App\Dto\Validation\Validators
 */
class MinimalLengthAndHasDigitsValidator extends Validator
{
    protected const MINIMAL_LENGTH = 6;
    protected $field;

    /**
     * CompareValuesValidator constructor.
     * @param Field $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed $value
     * @return bool
     * @throws Exceptions
     */
    public function validate($value): bool
    {
        $errors = new Exceptions();

        if (!empty($this->field->getValue())) {
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
        }

        if (!$errors->empty()) {
            throw $errors;
        }

        return true;
    }
}
