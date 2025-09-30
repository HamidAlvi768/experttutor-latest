<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserReferralCodes]].
 *
 * @see UserReferralCodes
 */
class UserReferralCodesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserReferralCodes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserReferralCodes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
