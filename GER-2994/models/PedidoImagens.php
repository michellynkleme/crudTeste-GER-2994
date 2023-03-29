<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido_imagens".
 *
 * @property int $id
 * @property int $pedido_id
 * @property string|null $imagem
 * @property string|null $capa
 *
 * @property Pedidos $pedido
 */
class PedidoImagens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_imagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pedido_id'], 'required'],
            [['pedido_id'], 'default', 'value' => null],
            [['pedido_id'], 'integer'],
            [['imagem', 'capa'], 'string', 'max' => 255],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedidos::class, 'targetAttribute' => ['pedido_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pedido_id' => 'Pedido ID',
            'imagem' => 'Imagem',
            'capa' => 'Capa',
        ];
    }

    /**
     * Gets query for [[Pedido]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedidos::class, ['id' => 'pedido_id']);
    }
}
