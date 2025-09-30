<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_professional_experience".
 *
 * @property int $id
 * @property int|null $teacher_id
 * @property string $organization
 * @property string $designation
 * @property string $start_date
 * @property string|null $end_date
 * @property string|null $association
 * @property string|null $job_role
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class TeacherProfessionalExperience extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_professional_experience';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['organization', 'designation', 'start_date'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['job_role'], 'string'],
            [['organization', 'association'], 'string', 'max' => 255],
            [['designation'], 'string', 'max' => 100],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Teacher ID',
            'organization' => 'Organization',
            'designation' => 'Designation',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'association' => 'Association',
            'job_role' => 'Job Role',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TeacherProfessionalExperienceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeacherProfessionalExperienceQuery(get_called_class());
    }
}
