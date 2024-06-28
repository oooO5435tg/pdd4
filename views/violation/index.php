<?php

use app\models\Violation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Violations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="violation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Violation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'car_id',
            'violation_date',
            'violation_time',
            'violation_type',
            'fine_amount',
            [
                'attribute' => 'is_paid',
                'value' => function ($model) {
                    return $model->is_paid ? 'Оплачено' : 'Не оплачено';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Violation $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
