<?php

namespace App\Dto\Validation\Validators;

use App\Exceptions\ConflictException;
use App\Models\Recourse;
use Runn\Core\Exceptions;
use Runn\Validation\Exceptions\EmptyValue;
use Runn\Validation\Validators\StringValidator;

/**
 * Class CompareValuesValidator
 * @package App\Dto\Validation\Validators
 */
class UniqueRecourseNumberValidator extends StringValidator
{
    /**
     * @param mixed $value
     * @return bool
     * @throws Exceptions
     * @throws \Runn\Validation\Exceptions\InvalidString
     */
    public function validate($value): bool
    {
        $errors = new Exceptions();

        if (empty($value)) {
            $errors[] = new EmptyValue($value);
        } else {
            if (!empty(Recourse::countAllByColumn('number', $value))) {
                $errors[] = new ConflictException();
            }
            parent::validate($value);
        }

        if (!$errors->empty()) {
            throw $errors;
        }

        return true;
    }

}
