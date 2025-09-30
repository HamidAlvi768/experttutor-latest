<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeacherEducation]].
 *
 * @see TeacherEducation
 */
class TeacherEducationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeacherEducation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeacherEducation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
