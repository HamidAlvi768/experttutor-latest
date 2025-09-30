<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_education".
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $institute_name
 * @property string $degree_type
 * @property string $degree_name
  * @property string $other_degree_name

 * @property string $start_date
 * @property string|null $end_date
 * @property string|null $association
 * @property string|null $specialization
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $teacher
 */
class TeacherEducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'institute_name', 'degree_type', 'degree_name', 'start_date'], 'required'],
            [['teacher_id'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['institute_name', 'association', 'specialization'], 'string', 'max' => 255],
            [['degree_type', 'degree_name','other_degree_name'], 'string', 'max' => 100],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['teacher_id' => 'id']],
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
            'institute_name' => 'Institute Name',
            'degree_type' => 'Degree Type',
            'degree_name' => 'Degree Name',
            'other_degree_name'=>'Other Degree Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'association' => 'Association',
            'specialization' => 'Specialization',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'teacher_id']);
    }

    /**
     * {@inheritdoc}
     * @return TeacherEducationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeacherEducationQuery(get_called_class());
    }
}
