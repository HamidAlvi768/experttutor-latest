<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Wallets]].
 *
 * @see Wallets
 */
class WalletsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Wallets[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Wallets|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
