<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wallet_transactions".
 *
 * @property int $id
 * @property int|null $wallet_id
 * @property string $transaction_type
 * @property float $amount
 * @property string|null $description
 * @property string $transaction_date
 * @property string|null $status
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class WalletTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wallet_id', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['transaction_type', 'amount'], 'required'],
            [['transaction_type', 'description', 'status'], 'string'],
            [['amount'], 'number'],
            [['transaction_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wallet_id' => 'Wallet ID',
            'transaction_type' => 'Transaction Type',
            'amount' => 'Amount',
            'description' => 'Description',
            'transaction_date' => 'Transaction Date',
            'status' => 'Status',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

   /**
     * Gets query for [[Wallet]].
     *
     * @return \yii\db\ActiveQuery|WalletQuery
     */

    
     public  function getTransactionWallet(){

        return $this->hasOne(Wallets::class, ['id' => 'wallet_id']);

    }
    /**
     * {@inheritdoc}
     * @return WalletTransactionsQuery the active query used by this AR class.
     */
// models/WalletTransactions.php

public function getWallet()
{
    return $this->hasOne(Wallets::class, ['id' => 'wallet_id']);
}


    public static function find()
    {
        return new WalletTransactionsQuery(get_called_class());
    }

    
}
