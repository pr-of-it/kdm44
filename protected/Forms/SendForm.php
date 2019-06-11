<?php

namespace App\Forms;

use App\Dto\UserRegister\RequestDto;
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
use Runn\Validation\Validators\IntValidator;
use Runn\Validation\Validators\StringValidator;

/**
 * Class SendForm
 * @package App\Forms
 */
class SendForm extends Form
{
    /**
     * SendForm constructor.
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        parent::__construct($data);
        $this->passwordConfirmation->setValidator(new CompareValuesValidator($this->password));
        $this->emailConfirmation->setValidator(new CompareValuesValidator($this->email));
        $this->password->setValidator(new MinimalLengthAndHasDigitsValidator($this->personalAccount));

        $this->setTemplate(new File(__DIR__ . '/Form.template.php'));
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
            'title' => 'Фамилия',
            'validator' => StringValidator::class
        ],
        'name' => [
            'class' => TextField::class,
            'title' => 'Имя',
            'validator' => StringValidator::class
        ],
        'fatherName' => [
            'class' => TextField::class,
            'title' => 'Отчество',
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
            'validator' => IntValidator::class
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

    /**
     * Метод возвращает массив данных формы как объект DTO
     * нужно для методов, где на вход нужно передавать именно объекты, но не массивы
     * @return RequestDto
     */
    public function getValueAsObject(): RequestDto
    {
        return new RequestDto($this->getValue());
    }

}
