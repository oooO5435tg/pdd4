<?php

use yii\helpers\Html;
use app\models\Violation;
use app\models\Car;

/** @var yii\web\View $this */
/** @var app\models\Violation $model */
/** @var app\models\Car $car */

$this->title = 'Обновление нарушения: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Нарушения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="violation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="violation-form">
        <?= Html::a('Оплатить штраф', ['pay', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="violation-info">
        <p>Статус оплаты: <?= $model->is_paid ? 'Оплачено' : 'Не оплачено' ?></p>
    </div>

</div>
