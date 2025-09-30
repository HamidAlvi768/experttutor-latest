<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_job_descriptions".
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $teacher
 */
class TeacherJobDescriptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_job_descriptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'description'], 'required'],
            [['teacher_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'description' => 'Description',
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
     * @return TeacherJobDescriptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeacherJobDescriptionsQuery(get_called_class());
    }
}
