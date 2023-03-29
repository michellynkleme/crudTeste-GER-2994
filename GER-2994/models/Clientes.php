<?php

namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $data_nasc
 * @property string|null $telefone
 * @property int $ativo
 *
 * @property Pedidos[] $pedidos
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cpf', 'data_nasc', 'ativo'], 'required'],
            [['data_nasc'], 'validateBirthday'],
            [['data_nasc'], 'date', 'format' => 'yyyy-MM-dd'],
            [['ativo'], 'default', 'value' => null],
            [['ativo'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['cpf', 'telefone'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cpf' => 'Cpf',
            'data_nasc' => 'Data Nascimento',
            'telefone' => 'Telefone',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Pedidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedidos::class, ['cliente_id' => 'id']);
    }

    public function validateBirthday()
    {
        $today = strtotime(date('Y-m-d'));
        $birthday = strtotime($this->data_nasc);

        if($today < $birthday){
            $this->addError('data_nasc', 'A data de nascimento deve ser menor que a data de hoje!');
        }
        return true;
    }
        
}
