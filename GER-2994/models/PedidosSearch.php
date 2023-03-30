<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedidos;

/**
 * PedidosSearch represents the model behind the search form of `app\models\Pedidos`.
 */
class PedidosSearch extends Pedidos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cliente_id', 'pedido_status_id', 'ativo'], 'integer'],
            [['produto', 'data'], 'safe'],
            [['valor'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Pedidos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'valor' => $this->valor,
            'data' => $this->data,
            'cliente_id' => $this->cliente_id,
            'pedido_status_id' => $this->pedido_status_id,
            'ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['ilike', 'produto', $this->produto]);
        
        return $dataProvider;
    }
}
