<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Coins;

/**
 * CoinsSearch represents the model behind the search form of `app\models\Coins`.
 */
class CoinsSearch extends Coins
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'coin_count', 'created_by', 'updated_by', 'discount'], 'integer'],
            [['coin_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = Coins::find();

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
            'coin_count' => $this->coin_count,
            'coin_price' => $this->coin_price,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'discount' => $this->discount,
        ]);

        return $dataProvider;
    }
}
