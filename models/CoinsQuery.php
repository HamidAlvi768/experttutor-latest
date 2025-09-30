<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Coins]].
 *
 * @see Coins
 */
class CoinsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Coins[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Coins|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
