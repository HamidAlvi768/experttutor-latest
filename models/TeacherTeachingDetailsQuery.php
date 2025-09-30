<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeacherTeachingDetails]].
 *
 * @see TeacherTeachingDetails
 */
class TeacherTeachingDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeacherTeachingDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeacherTeachingDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
