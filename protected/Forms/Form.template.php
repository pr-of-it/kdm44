<?php

use App\Dto\Validation\Exceptions\CompareException;
use App\Dto\Validation\Exceptions\InvalidPhone;
use App\Dto\Validation\Exceptions\MinimalLengthException;
use App\Dto\Validation\Exceptions\NoDigitsException;
use Runn\Html\Form\Fields\InputField;
use Runn\Validation\Exceptions\EmptyValue;
use Runn\Validation\Exceptions\InvalidEmail;
use Runn\Validation\Exceptions\InvalidString;

?>

<?php
foreach ($this as $key => $element):
    ?>
    <div class="form-group mb-3">
        <?php
        if ($element instanceof InputField):
            if (!$element->errors()->empty()): ?>

                <div class="alert alert-danger">
                    <ul>
                        <?php
                        foreach ($element->errors() as $error) { ?>
                            <?php if ($error->getPrevious() instanceof EmptyValue) {?>
                                <li><?php echo 'Поле ' . $element->getTitle() . ' не заполнено'; ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof InvalidEmail) { ?>
                                <li><?php echo 'Неверный адрес электронной почты в поле ' . $element->getTitle(); ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof MinimalLengthException) { ?>
                                <li><?php echo 'Поле ' . $element->getTitle() . ' должно содержать не менее 6 символов'; ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof NoDigitsException) { ?>
                                <li><?php echo 'В поле ' . $element->getTitle() . ' должна быть как минимум одна цифра'; ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof CompareException) { ?>
                                <li><?php echo 'Значение поля "' . $element->getTitle() . '" не совпадает со значением поля "' . $error->getPrevious()->compareField->getTitle() . '"'; ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof InvalidPhone) { ?>
                                <li><?php echo 'Неверный номер телефона в поле ' . $element->getTitle(); ?></li>
                            <?php }
                            if ($error->getPrevious() instanceof InvalidString) { ?>
                                <li><?php echo 'Неверное название поля ' . $element->getTitle(); ?></li>
                            <?php }

                        }?>
                    </ul>
                </div>

            <?php endif;
        endif; ?>
    </div>
<?php
endforeach;
?>
