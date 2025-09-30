<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_job_posts".
 *
 * @property int $id
 * @property int|null $posted_by
 * @property string $title
 * @property string $details
 * @property string $location
 * @property string $phone_number
 * @property string $subject
 * @property string|null $level
 * @property string|null $want
 * @property string|null $meeting_option
 * @property string|null $post_code
 * @property int|null $budget
 * @property string|null $gender
 * @property string|null $need_some
 * @property string|null $tutor_from
 * @property string|null $post_status
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class StudentJobPosts extends \yii\db\ActiveRecord
{

        /**
     * @var UploadedFile
     */
    public $documentsFile;  // Add this line to handle the file upload






    /**
     * {@inheritdoc}
     */





    public function uploadAvatar()
{
    $username = Yii::$app->user->identity->username;

    if ($this->documentsFile) {
        $path = 'uploads/documents/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = str_replace(' ', '_', $username) . '_' . time() . '.' . $this->documentsFile->extension;
        $filePath = $path . $fileName;

        if ($this->documentsFile->saveAs($filePath)) {
            return '/' . $filePath; // prepend / for web access
        }
    }

    return false;
}
    
    public static function tableName()
    {
        return 'student_job_posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Integer fields, must not be negative
            [['posted_by', 'active', 'deleted', 'created_by', 'updated_by', 'call_option'], 'integer', 'min' => 0],
            // Budget must be integer and at least 1
            ['budget', 'integer', 'min' => 1, 'tooSmall' => 'Budget must be at least $1.'],
            // Required fields
            [['title', 'details', 'phone_number', 'subject','budget','charge_type','location'], 'required'],
            // String fields
            [['phone_number'] ,'integer', 'message' => 'Phone number must be a valid number.'],
            [['post_code'] ,'integer', 'message' => 'Post code must be a valid number.'],
            [['details', 'want', 'gender', 'need_some', 'post_status'], 'string'],
            [['created_at', 'updated_at','post_code','document'], 'safe'],
            [['title', 'location'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['subject','other_subject', 'level', 'tutor_from'], 'string', 'max' => 100],
            [['meeting_option'], 'string', 'max' => 50],
            [
                ['document'], 
                'file', 
                'skipOnEmpty' => true, 
                'extensions' => ['pdf', 'doc', 'docx'], // allowed file types
                'maxSize' => 1024 * 1024 * 1, // 1 MB
                'wrongExtension' => 'Only {extensions} files are allowed.',
                'tooBig' => 'File size cannot exceed 1 MB.'
            ],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'posted_by' => 'Posted By',
            'title' => 'Title',
            'details' => 'Details',
            'location' => 'Location',
            'phone_number' => 'Phone Number',
            'subject' => 'Subject',
            'other_subject'=>'Other Subject',
            'level' => 'Level',
            'want' => 'Want',
            'meeting_option' => 'Meeting Option',
            'post_code' => 'Post Code',
            'budget' => 'Budget',
            'gender' => 'Gender',
            'need_some' => 'Need Some',
            'tutor_from' => 'Tutor From',
            'post_status' => 'Post Status',
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
     * @return StudentJobPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentJobPostsQuery(get_called_class());
    }

    public function getPostedBy()
    {
        return $this->hasOne(User::class, ['id' => 'posted_by']);
    }
    public function getMessages()
    {
        return $this->hasMany(ChatMessages::class, ['job_post_id' => 'id']);
    }
    public function getApplies()
    {
        return $this->hasMany(JobApplications::class, ['job_id' => 'id']);
    }
}
