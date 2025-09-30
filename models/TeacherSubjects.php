<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_subjects".
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $subject
 * @property string $from_level
 * @property string $to_level
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $teacher
 */
class TeacherSubjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_subjects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'subject', 'from_level', 'to_level'], 'required'],
            [['teacher_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['from_level', 'to_level'], 'string', 'max' => 100],
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
            'subject' => 'Subject',
            'from_level' => 'From Level',
            'to_level' => 'To Level',
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
     * @return TeacherSubjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeacherSubjectsQuery(get_called_class());
    }
}
