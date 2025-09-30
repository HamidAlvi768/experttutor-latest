<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeacherJobDescriptions]].
 *
 * @see TeacherJobDescriptions
 */
class TeacherJobDescriptionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeacherJobDescriptions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeacherJobDescriptions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
