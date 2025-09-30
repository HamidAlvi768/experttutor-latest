<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_applications".
 *
 * @property int $id
 * @property int $job_id
 * @property int $applicant_id
 * @property string|null $application_status
 * @property string $applied_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class JobApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_applications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'applicant_id'], 'required'],
            [['job_id', 'applicant_id', 'created_by', 'updated_by'], 'integer'],
            [['applied_at', 'updated_at'], 'safe'],
            [['application_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'applicant_id' => 'Applicant ID',
            'application_status' => 'Application Status',
            'applied_at' => 'Applied At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JobApplicationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobApplicationsQuery(get_called_class());
    }
}
