<?php

$this->registerJsFile('@web/js/script.js', [
    'depends' => [\app\assets\AppAsset::class]
]);

?>

<div class="block-wrapper d-flex flex-column">
    <div class="block-title w-50 align-self-center text-center p-2">
        <h3 class="">Введите ссылку ниже</h3>
    </div>

    <div class="block-form">
        <?php use yii\helpers\Html;

        $form = yii\widgets\ActiveForm::begin([
            'id' => 'short-url-form',
            'action' => \yii\helpers\Url::to(['site/generate-url']),
            'enableAjaxValidation' => true,
            'validateOnChange' => false,
            'validateOnBlur' => false,
            'validateOnType' => false,
            'validateOnSubmit' => false,
            'enableClientValidation' => false
        ]); ?>

        <div class="url-input-block d-flex align-items-start gap-3 w-75 mx-auto">
            <div class="url-input-field flex-grow-1">
                <?= $form->field($model, 'url', [
                    'options' => ['class' => 'mb-0'],
                    'errorOptions' => ['class' => 'text-danger small']
                ])->textInput(['class' => 'form-control']) ?>
            </div>

            <div class="submit-btn-wrapper">
                <?= Html::submitButton('Сгенерировать', ['class' => 'btn btn-primary', 'id' => 'submit-button']) ?>
            </div>
        </div>

        <?php yii\widgets\ActiveForm::end(); ?>
    </div>

    <div class="block-links-info">
        <div class="loader-block d-none">
            <img src="/icons/loader.gif" alt="Loading..." width="35px" height="35px" class="d-block mx-auto mt-5">
        </div>
        <p class="info-message text-center text-danger fs-5 pt-3 d-none"></p>

        <div class="links-info-container pt-3"></div>

    </div>
</div>

