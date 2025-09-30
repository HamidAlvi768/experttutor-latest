<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wallets".
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $balance
 * @property float|null $membership_coins

 * @property string|null $currency
 * @property string $created_at
 * @property string $updated_at
 * @property string $memb_expiry

 *
 * @property Transactions[] $transactions
 * @property Users $user
 */
class Wallets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','memb_expiry'], 'required'],
            [['user_id'], 'integer'],
            [['balance'], 'number'],
            [['created_at', 'updated_at','memb_expiry','membership_coins'], 'safe'],
            [['currency'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'balance' => 'Balance',
            'membership_coins'=>'MemberShip Coins',
            'currency' => 'Currency',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery|TransactionsQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(WalletTransactions::class, ['wallet_id' => 'id']);
    }
    

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    // models/Wallets.php




    /**
     * {@inheritdoc}
     * @return WalletsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WalletsQuery(get_called_class());
    }


    
}
