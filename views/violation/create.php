<?php

use yii\helpers\Html;
use app\models\Car;

/** @var yii\web\View $this */
/** @var app\models\Violation $model */
/** @var app\models\Car $car */

$this->title = 'Create Violation';
$this->params['breadcrumbs'][] = ['label' => 'Violations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="violation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'car' => $car,
    ]) ?>

</div>
