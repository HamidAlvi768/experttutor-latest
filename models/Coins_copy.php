<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coins".
 *
 * @property int $id
 * @property int $coin_count
 * @property float $coin_price
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Coins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coin_count', 'coin_price'], 'required'],
            [['coin_count', 'created_by', 'updated_by'], 'integer'],
            [['coin_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coin_count' => 'Coin Count',
            'coin_price' => 'Coin Price',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CoinsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CoinsQuery(get_called_class());
    }
}
