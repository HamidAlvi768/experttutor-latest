<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeacherSubjects]].
 *
 * @see TeacherSubjects
 */
class TeacherSubjectsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeacherSubjects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeacherSubjects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
