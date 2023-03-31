<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidos".
 *
 * @property int $id
 * @property string $produto
 * @property float $valor
 * @property string $data
 * @property int|null $cliente_id
 * @property int $pedido_status_id
 * @property int $ativo
 *
 * @property Clientes $cliente
 * @property PedidoImagens[] $imagemPedido
 * @property PedidoStatus $pedidoStatus
 */
class Pedidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto', 'valor', 'data', 'cliente_id', 'pedido_status_id', 'ativo'], 'required'],
            [['valor'], 'number'],
            [['data'], 'date', 'format' => 'yyyy-MM-dd'],
            [['cliente_id', 'pedido_status_id', 'ativo'], 'default', 'value' => null],
            [['cliente_id', 'pedido_status_id', 'ativo'], 'integer'],
            [['produto'], 'string', 'max' => 255],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['pedido_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => PedidoStatus::class, 'targetAttribute' => ['pedido_status_id' => 'id']],
            [['pedidoImagens'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto' => 'Produto',
            'valor' => 'Valor',
            'data' => 'Data',
            'cliente_id' => 'Cliente',
            'pedido_status_id' => 'Status do pedido',
            'ativo' => 'Status do registro do pedido',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::class, ['id' => 'cliente_id']);
    }

    /**
     * Gets query for [[PedidoImagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoImagens()
    {
        return $this->hasOne(PedidoImagens::class, ['pedido_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoStatus()
    {
        return $this->hasOne(PedidoStatus::class, ['id' => 'pedido_status_id']);
    }


}
