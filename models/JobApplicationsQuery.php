<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JobApplications]].
 *
 * @see JobApplications
 */
class JobApplicationsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JobApplications[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JobApplications|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
