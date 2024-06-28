<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Violation;
use app\models\Car;

/** @var yii\web\View $this */
/** @var app\models\Violation $model */

?>

<div class="violation-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($car, 'reg_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'violation_date')->textInput() ?>
    <?= $form->field($model, 'violation_time')->textInput() ?>
    <?= $form->field($model, 'violation_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fine_amount')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_paid')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Оплатить штраф', ['class' => 'btn btn-success', 'name' => 'pay']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
