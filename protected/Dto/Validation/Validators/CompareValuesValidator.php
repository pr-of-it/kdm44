<?php

namespace App\Dto\Validation\Validators;

use App\Dto\Validation\Exceptions\CompareException;
use Runn\Core\Exceptions;
use Runn\Html\Form\Field;
use Runn\Validation\Exceptions\EmptyValue;
use Runn\Validation\Validator;

/**
 * Class CompareValuesValidator
 * @package App\Dto\Validation\Validators
 */
class CompareValuesValidator extends Validator
{

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
                if ($this->field->getValue() !== $value) {
                    $errors[] = new CompareException($value, $this->field);
                }
            }
        }

        if (!$errors->empty()) {
            throw $errors;
        }

        return true;
    }

}
