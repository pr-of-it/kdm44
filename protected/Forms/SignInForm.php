<?php

namespace App\Forms;

use App\Dto\UserLogin\RequestDto;
use App\Dto\Validation\Validators\MinimalLengthAndHasDigitsValidator;
use Runn\Fs\File;
use Runn\Html\Form\Buttons\SubmitButton;
use Runn\Html\Form\Fields\EmailField;
use Runn\Html\Form\Fields\PasswordField;
use Runn\Html\Form\Form;
use Runn\Validation\Validators\EmailValidator;

/**
 * Class SendForm
 * @package App\Forms
 */
class SignInForm extends Form
{
    /**
     * SendForm constructor.
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        parent::__construct($data);
        $this->setTemplate(new File(__DIR__ . '/Form.template.php'));
    }

    protected static $schema = [
        'email' => [
            'class' => EmailField::class,
            'title' => 'Введите e-mail',
            'validator' => EmailValidator::class
        ],
        'password' => [
            'class' => PasswordField::class,
            'title' => 'Введите пароль',
            'validator' => MinimalLengthAndHasDigitsValidator::class,
        ],

        'submit' => ['class' => SubmitButton::class, 'title' => 'Войти в личный кабинет']
    ];
}
