<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserLeaveLog]].
 *
 * @see UserLeaveLog
 */
class UserLeaveLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserLeaveLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserLeaveLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
