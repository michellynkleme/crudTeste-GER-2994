<?php

use app\models\Pedidos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\PedidosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedidos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Pedido', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Exportar CSV', ['export'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'produto',
            'valor',
            'data',
            ['attribute' => 'cliente_id',
            'value' => 'cliente.nome'],
            ['attribute' => 'pedido_status_id',
            'value' => 'pedidoStatus.descricao'],
            ['attribute' => 'ativo',
            'value' => function($model) {
                return ($model->ativo) == 1 ? 'Ativo' : 'Inativo';
                }
            ],
            ['attribute' => 'pedidoImagens',
            'format' => "raw",
            'value' => function($model) {
                if (isset($model->pedidoImagens->capa)) {
                    $root = Url::to('@web/files');
                    $root = $root .'/'. $model->pedidoImagens->capa;
                    return ("<img src='".$root."'>");
                }
            }],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Pedidos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
