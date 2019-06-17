<?php

namespace App\Forms;

use App\Dto\Validation\Validators\CompareValuesValidator;
use App\Dto\Validation\Validators\MinimalLengthAndHasDigitsValidator;
use Runn\Fs\File;
use Runn\Html\Form\Buttons\SubmitButton;
use Runn\Html\Form\Fields\PasswordField;
use Runn\Html\Form\Form;

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
