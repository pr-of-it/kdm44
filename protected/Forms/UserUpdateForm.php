<?php

namespace App\Forms;

use App\Dto\Validation\Validators\CompareValuesValidator;
use App\Dto\Validation\Validators\MinimalLengthAndHasDigitsValidator;
use App\Dto\Validation\Validators\PhoneNumberValidator;
use Runn\Fs\File;
use Runn\Html\Form\Buttons\SubmitButton;
use Runn\Html\Form\Fields\PasswordField;
use Runn\Html\Form\Fields\TextField;
use Runn\Html\Form\Form;
use Runn\Validation\Validators\StringValidator;

/**
 * Class UserUpdateForm
 * @package App\Forms
 */
class UserUpdateForm extends Form
{
    /**
     * SendForm constructor.
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        parent::__construct($data);
        $this->passwordConfirmation->setValidator(new CompareValuesValidator($this->password));
        $this->setTemplate(new File(__DIR__ . '/Form.template.php'));
    }

    protected static $schema = [
        'firstName' => [
            'class' => TextField::class,
            'title' => 'Имя',
            'validator' => StringValidator::class
        ],
        'middleName' => [
            'class' => TextField::class,
            'title' => 'Отчество',
            'validator' => StringValidator::class
        ],
        'lastName' => [
            'class' => TextField::class,
            'title' => 'Фамилия',
            'validator' => StringValidator::class
        ],
        'organization' => [
            'class' => TextField::class,
            'title' => 'Организация',
            'validator' => StringValidator::class
        ],
        'phone' => [
            'class' => TextField::class,
            'title' => 'Номер телефона',
            'validator' => PhoneNumberValidator::class
        ],
        'password' => [
            'class' => PasswordField::class,
            'title' => 'Введите новый пароль',
            'validator' => MinimalLengthAndHasDigitsValidator::class,
        ],
        'passwordConfirmation' => [
            'class' => PasswordField::class,
            'title' => 'Повторите пароль',
        ],

        'submit' => ['class' => SubmitButton::class, 'title' => 'Сохранить']
    ];
}
