<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int|null $job_post_id
 * @property int|null $sender_id
 * @property int|null $receiver_id
 * @property string $message
 * @property int|null $is_read
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class ChatMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_post_id', 'sender_id', 'receiver_id', 'is_read', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['message'], 'required'],
            [['message', 'attachment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_post_id' => 'Job Post ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'message' => 'Message',
            'attachment' => 'Attachment',
            'is_read' => 'Is Read',
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
     * @return ChatMessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChatMessagesQuery(get_called_class());
    }

    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }
}
