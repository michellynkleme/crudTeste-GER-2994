<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pedidos $model */

$this->title = 'Update Pedidos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pedidos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelImagem' => $modelImagem,
        'pedidoStatus' => $pedidoStatus,
        'clientes' => $clientes,
    ]) ?>

</div>
