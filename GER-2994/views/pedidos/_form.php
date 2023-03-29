<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pedidos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedidos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'cliente_id')->textInput() ?>

    <?= $form->field($model, 'pedido_status_id')->textInput() ?>

    <?= $form->field($model, 'ativo')->textInput() ?>

    <?= $form->field($model, 'pedidoImagens')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
