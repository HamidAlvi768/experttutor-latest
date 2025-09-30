<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Manageusers;

class ManageusersSearch extends Manageusers
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'role', 'user_status', 'verification'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // Skip parent scenarios() for simplicity
        return Model::scenarios();
    }

    public function search($params, $role)
    {
        if (!empty($role)) {
            $query = Manageusers::find()->where([ 'role'=> $role]);

        } else {
           $query= Manageusers::find(); // example: exclude superadmin
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'query' => Manageusers::find()->where(['!=', 'role', 'superadmin']),
             'pagination' => [
            'pageSize' => 20,
        ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
  
        $query->andFilterWhere(['id' => $this->id])
              ->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'role', $this->role])
              ->andFilterWhere(['like', 'user_status', $this->user_status])
              ->andFilterWhere(['like', 'verification', $this->verification]);
// echo "<pre>";
// var_dump($query->createCommand()->getRawSql());
// exit;
        return $dataProvider;
    }
}