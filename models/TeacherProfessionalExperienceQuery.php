<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TeacherProfessionalExperience]].
 *
 * @see TeacherProfessionalExperience
 */
class TeacherProfessionalExperienceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TeacherProfessionalExperience[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeacherProfessionalExperience|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
