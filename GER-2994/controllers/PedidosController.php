<?php

namespace app\controllers;

use app\models\Clientes;
use app\models\ClientesSearch;
use app\models\PedidoImagens;
use app\models\Pedidos;
use app\models\PedidosSearch;
use app\models\PedidoStatus;
use Imagine\Imagick\Imagine;
use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii2tech\csvgrid\CsvGrid;

/**
 * PedidosController implements the CRUD actions for Pedidos model.
 */
class PedidosController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Pedidos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PedidosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pedidos model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pedidos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pedidos();
        $pedidoImagem = new PedidoImagens;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->save();
                if (UploadedFile::getInstance($pedidoImagem, 'imagemPedido')){
                    $imagem = UploadedFile::getInstance($pedidoImagem, 'imagemPedido');
                    $this->saveImage($imagem, $model->id);
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
            $pedidoImagem->loadDefaultValues();
        }

        $pedidoStatus = PedidoStatus::find()->orderBy('id')->asArray()->all();
        $pedidoStatus = ArrayHelper::map($pedidoStatus, 'id', 'descricao');
        
        $clientes = Clientes::find()->select('id, nome')->orderBy('id')->asArray()->all();
        $clientes = ArrayHelper::map($clientes, 'id', 'nome');


        return $this->render('create', [
            'model' => $model,
            'modelImagem' => $pedidoImagem,
            'pedidoStatus' => $pedidoStatus,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Updates an existing Pedidos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pedidoImagem = new PedidoImagens;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if (UploadedFile::getInstance($pedidoImagem, 'imagemPedido')){
                $imagem = UploadedFile::getInstance($pedidoImagem, 'imagemPedido');
                $this->saveImage($imagem, $model->id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $pedidoStatus = PedidoStatus::find()->orderBy('id')->asArray()->all();
        $pedidoStatus = ArrayHelper::map($pedidoStatus, 'id', 'descricao');
        
        $clientes = Clientes::find()->select('id, nome')->orderBy('id')->asArray()->all();
        $clientes = ArrayHelper::map($clientes, 'id', 'nome');


        return $this->render('update', [
            'model' => $model,
            'modelImagem' => $pedidoImagem,
            'pedidoStatus' => $pedidoStatus,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Deletes an existing Pedidos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionExport()
    {
        $searchModel = new PedidosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $exporter = new CsvGrid([
            'dataProvider' => new ActiveDataProvider([
                'query' => Pedidos::find(),
            ]),
            'columns' => [
                'id',
                'produto',
                'valor',
                'data',
                ['attribute' => 'cliente.nome'],
                ['attribute' => 'pedidoStatus.descricao'],
                'ativo',
            ],
        ]);
        return $exporter->export()->send('items.csv');
    }

    /**
     * Finds the Pedidos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pedidos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedidos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function saveImage($imagem, $pedidoId)
    {
        try{
            $pedidoImagem = new PedidoImagens;
            $pedidoImagem->imagemPedido = $imagem;
            $pedidoImagem->imagem = $pedidoImagem->imagemPedido->name;
    
            $uploadPath= Yii::getAlias('@webroot/files');
            $pathCapa = 'capa'.$pedidoImagem->imagem;
            $pedidoImagem->imagemPedido->saveAs($uploadPath .'/'.$pedidoImagem->imagem);
            $pedidoImagem->pedido_id = $pedidoId;
            $imagine = new Image;
            $imagine1 = $imagine->getImagine();
            $image = $imagine1->open($uploadPath .'/'. $pedidoImagem->imagemPedido->name);
            $image->resize(new Box(90,100))
                  ->save($uploadPath.'/'.$pathCapa, ['quality' => 70]);
            
            $pedidoImagem->capa = $pathCapa;
            $pedidoImagem->save();
        } catch (ErrorException $e) {
            Yii::warning("Houve um erro ao salvar sua imagem. Verifique se ela é um arquivo PNG ou JPG.");
        }

    }
}
