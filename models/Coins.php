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
 * @property int $discount
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
            [['coin_count', 'coin_price', 'discount'], 'required'],
            [['coin_count', 'created_by', 'updated_by', 'discount'], 'integer'],
            [['coin_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            
            // Ensure non-negative values
            [['coin_count'], 'integer', 'min' => 1, 'message' => 'Coin count must be at least 1.'],
            [['coin_price'], 'number', 'min' => 0, 'message' => 'Coin price cannot be negative.'],
            [['discount'], 'integer', 'min' => 0, 'max' => 100, 'message' => 'Discount must be between 0 and 100 percent.'],
            
            // Ensure created_by and updated_by are non-negative if provided
            [['created_by', 'updated_by'], 'integer', 'min' => 0],
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
            'discount' => 'Discount',
        ];
    }
}
