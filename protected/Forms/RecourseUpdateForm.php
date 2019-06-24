<?php

namespace App\Forms;

use App\Dto\Validation\Validators\UniqueRecourseNumberValidator;
use Runn\Fs\File;
use Runn\Html\Form\Buttons\SubmitButton;
use Runn\Html\Form\Fields\TextField;
use Runn\Html\Form\Form;
use Runn\Validation\Validators\StringValidator;

/**
 * Class RecourseProcessingForm
 * @package App\Forms
 */
class RecourseUpdateForm extends Form
{
    /**
     * RecourseProcessingForm constructor.
     * @param iterable|null $data
     */
    public function __construct(?iterable $data = null)
    {
        parent::__construct($data);
        $this->setTemplate(new File(__DIR__ . '/Form.template.php'));
    }

    protected static $schema = [
        'type' => [
            'class' => TextField::class,
            'title' => 'Статус',
            'validator' => StringValidator::class
        ],
        'status' => [
            'class' => TextField::class,
            'title' => 'Статус',
            'validator' => StringValidator::class
        ],
        'number' => [
            'class' => TextField::class,
            'title' => 'Номер',
            'validator' => UniqueRecourseNumberValidator::class
        ],
        'comment' => [
            'class' => TextField::class,
            'title' => 'Комментарий',
            'validator' => StringValidator::class
        ],

        'submit' => ['class' => SubmitButton::class, 'title' => 'Сохранить']
    ];
}
