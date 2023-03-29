<?php

/** @var yii\web\View $this */

use yii\helpers\Url as HelpersUrl;

$this->title = 'Teste CRUD';
?>
<div class="site-index">

    <div class="body-content jumbotron text-center bg-transparent">

        <div class="row">
            <div class="col-lg-6">
            <p><a class="btn btn-lg btn-success" href="<?= HelpersUrl::to('@web/index.php/clientes/create');?>">Novo Cliente</a></p>
            <p><a class="btn btn-lg btn-success" href="<?= HelpersUrl::to('@web/index.php/clientes/index');?>">Visualizar Clientes</a></p>
            </div>
            <div class="col-lg-6">
            <p><a class="btn btn-lg btn-success" href="<?= HelpersUrl::to('@web/index.php/pedidos/create');?>">Novo Pedido</a></p>
            <p><a class="btn btn-lg btn-success" href="<?= HelpersUrl::to('@web/index.php/pedidos/index');?>">Visualizar Pedidos</a></p>
            </div>
        </div>

    </div>
</div>
