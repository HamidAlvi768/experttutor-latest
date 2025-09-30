<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_leave_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $message
 * @property string|null $start_at
 * @property string|null $left_at
 */
class UserLeaveLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_leave_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['start_at', 'left_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'start_at' => 'Start At',
            'left_at' => 'Left At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserLeaveLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserLeaveLogQuery(get_called_class());
    }
}
