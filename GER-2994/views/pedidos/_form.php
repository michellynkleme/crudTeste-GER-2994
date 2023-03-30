<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pedidos $model */
/** @var app\models\PedidoImagens $modelImagem */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedidos-form">

    <?php $form = ActiveForm::begin(); ?>
<br>
    <?= $form->field($model, 'produto')->textInput(['maxlength' => true]) ?>
<br>
    <?= $form->field($model, 'valor')->textInput() ?>
<br>
    <?= $form->field($model, 'data')->widget(DatePicker::class, [
    'options' => ['class' => 'form-control'],
    'language' =>  'pt_BR',
    'dateFormat' => 'yyyy-MM-dd'
    ]) ?>
<br>
    <?= $form->field($model, 'cliente_id')->dropDownList($clientes, ['prompt' => 'Selecione o cliente']) ?>
<br>
    <?= $form->field($model, 'pedido_status_id')->dropDownList($pedidoStatus, ['prompt' => 'Selecione o status']) ?>
<br>
    <?= $form->field($model, 'ativo')->radioList([1 => 'Ativo', 0 => 'Inativo']) ?>
<br>
    <?= $form->field($modelImagem, 'imagemPedido')->fileInput() ?>
<br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<br>
    <?php ActiveForm::end(); ?>

</div>
