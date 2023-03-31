<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Clientes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(); ?>
    <br>
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'data_nasc')->widget(DatePicker::class, [
    'options' => ['class' => 'form-control'],
    'language' =>  'pt_BR',
    'dateFormat' => 'yyyy-MM-dd'
    ]) ?>
<br>
    <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'ativo')->radioList([1 => 'Ativo', 0 => 'Inativo']) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <br>
    <?php ActiveForm::end(); ?>
    <br>
    <br>
</div>
