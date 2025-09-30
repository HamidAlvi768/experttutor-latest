<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentJobPosts]].
 *
 * @see StudentJobPosts
 */
class StudentJobPostsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StudentJobPosts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StudentJobPosts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
