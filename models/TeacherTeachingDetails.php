<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_teaching_details".
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $charge_type
 * @property int $minimum_fee
 * @property int|null $maximum_fee
 * @property string|null $fee_details
 * @property int|null $total_experience
 * @property int|null $teaching_experience
 * @property int|null $online_teaching_experience
 * @property int|null $travel_to_student
 * @property int|null $available_for_online
 * @property int|null $digital_pen
 * @property int|null $help_work_assignments
 * @property int|null $working_at_school
 * @property string|null $opportunity_interested
 * @property string|null $communication_language
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $teacher
 */
class TeacherTeachingDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_teaching_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'charge_type', 'minimum_fee'], 'required'],
            [['teacher_id', 'minimum_fee', 'maximum_fee', 'total_experience', 'teaching_experience', 'online_teaching_experience', 'travel_to_student', 'available_for_online', 'digital_pen', 'help_work_assignments', 'working_at_school'], 'integer'],
            [['minimum_fee', 'maximum_fee'], 'integer', 'min' => 0],
            ['maximum_fee', 'compare', 'compareAttribute' => 'minimum_fee', 'operator' => '>=', 'type' => 'number', 'when' => function($model) { return $model->maximum_fee !== null; }, 'message' => 'Maximum Fee must be greater than or equal to Minimum Fee.'],
            [['fee_details'], 'string'],
            [['created_at', 'updated_at', 'communication_language'], 'safe'],
            [['charge_type'], 'string', 'max' => 100],
            [['opportunity_interested'], 'string', 'max' => 255],
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
            'charge_type' => 'Charge Type',
            'minimum_fee' => 'Minimum Fee',
            'maximum_fee' => 'Maximum Fee',
            'fee_details' => 'Fee Details',
            'total_experience' => 'Total Experience',
            'teaching_experience' => 'Teaching Experience',
            'online_teaching_experience' => 'Online Teaching Experience',
            'travel_to_student' => 'Travel To Student',
            'available_for_online' => 'Available For Online',
            'digital_pen' => 'Digital Pen',
            'help_work_assignments' => 'Help Work Assignments',
            'working_at_school' => 'Working At School',
            'opportunity_interested' => 'Opportunity Interested',
            'communication_language' => 'Communication Language',
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
     * @return TeacherTeachingDetailsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeacherTeachingDetailsQuery(get_called_class());
    }
}
