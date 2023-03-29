<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PedidosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedidos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'produto') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'cliente_id') ?>

    <?php // echo $form->field($model, 'pedido_status_id') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
