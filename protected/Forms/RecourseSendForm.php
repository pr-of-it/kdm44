<?php

namespace App\Forms;

use App\Dto\Validation\Validators\CompareValuesValidator;
use App\Dto\Validation\Validators\EmailOrNullValidator;
use App\Dto\Validation\Validators\MinimalLengthAndHasDigitsValidator;
use App\Dto\Validation\Validators\PhoneNumberValidator;
use Runn\Fs\File;
use Runn\Html\Form\Buttons\SubmitButton;
use Runn\Html\Form\Fields\CheckboxField;
use Runn\Html\Form\Fields\EmailField;
use Runn\Html\Form\Fields\PasswordField;
use Runn\Html\Form\Fields\TextareaField;
use Runn\Html\Form\Fields\TextField;
use Runn\Html\Form\Form;
use Runn\Validation\Validators\BooleanValidator;
use Runn\Validation\Validators\EmailValidator;
use Runn\Validation\Validators\StringValidator;

/**
 * Class RecourseSendForm
 * @package App\Forms
 */
class RecourseSendForm extends Form
{
    /**
     * RecourseSendForm constructor.
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        parent::__construct($data);
        $this->emailConfirmation->setValidator(new CompareValuesValidator($this->email));
        $this->setTemplate(new File(__DIR__ . '/Form.template.php'));
    }

    /**
     * Если personalAccount не пустой, то валидируем пароль и повтор пароля
     */
    public function validatePassword(): void
    {
        if (!empty($this->personalAccount->getValue())) {
            $this->password->setValidator(new MinimalLengthAndHasDigitsValidator())->validate();
            $this->passwordConfirmation->setValidator(new CompareValuesValidator($this->password))->validate();
        }
    }

    protected static $schema = [
        'email' => [
            'class' => EmailField::class,
            'title' => 'Адрес электронной почты',
            'validator' => EmailValidator::class
        ],
        'emailConfirmation' => [
            'class' => EmailField::class,
            'title' => 'Повторите адрес электронной почты',
            'validator' => EmailValidator::class
        ],
        'password' => [
            'class' => PasswordField::class,
            'title' => 'Пароль'
        ],
        'passwordConfirmation' => [
            'class' => PasswordField::class,
            'title' => 'Повторите пароль'
        ],
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
        'recipient' => [
            'class' => CheckboxField::class,
            'title' => 'Кому направляете',
            'validator' => StringValidator::class
        ],
        'executive' => [
            'class' => TextField::class,
            'title' => 'Должностное лицо',
            'validator' => StringValidator::class
        ],
        'coauthorName' => [
            'class' => TextField::class,
            'title' => 'Имя соавтора',
            'validator' => StringValidator::class
        ],
        'coauthorEmail' => [
            'class' => EmailField::class,
            'title' => 'Email соавтора',
            'validator' => EmailOrNullValidator::class
        ],
        'message' => [
            'class' => TextareaField::class,
            'title' => 'Сообщение',
            'validator' => StringValidator::class
        ],
        'personalAccount' => [
            'class' => CheckboxField::class,
            'title' => 'Создать личный кабинет',
            'validator' => BooleanValidator::class
        ],

        'submit' => ['class' => SubmitButton::class, 'title' => 'Направить письмо']
    ];
}
