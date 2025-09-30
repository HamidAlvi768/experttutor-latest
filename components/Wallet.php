<?php

namespace app\components;

use app\models\Wallets;
use app\models\WalletTransactions;

class Wallet
{

    public static function Debit($id, $coins, $status, $description)
    {
        $userWallet = Wallets::find()->where(['user_id' => $id])->one();
        if ($userWallet->balance >= $coins) {
            $userWallet->balance -= $coins;
            $userWallet->save();

            // TRANSACTION RECORD
            $transaction = new WalletTransactions();
            $transaction->wallet_id = $userWallet->id;
            $transaction->transaction_type = "debit";
            $transaction->amount = $coins;
            $transaction->description = $description;
            $transaction->status = $status;
            $transaction->save();
            return true;
        }
        return false;
    }
    public static function Credit($id, $coins, $status, $description)
    {
        $userWallet = Wallets::find()->where(['user_id' => $id])->one();
        if ($userWallet) {
            $userWallet->balance += $coins;
            $userWallet->save();

            // TRANSACTION RECORD
            $transaction = new WalletTransactions();
            $transaction->wallet_id = $userWallet->id;
            $transaction->transaction_type = "credit";
            $transaction->amount = $coins;
            $transaction->description = $description;
            $transaction->status = $status;
            $transaction->save();
            return true;
        }
        return false;
    }
}
