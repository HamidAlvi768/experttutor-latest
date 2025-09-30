<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class Profiles extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $avatarFile;  // Add this line to handle the file upload

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['user_id', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
    //         [['gender', 'address', 'avatar_url'], 'string'],
    //         [['full_name', 'nick_name', 'gender','country','phone_number'], 'required'], // Added required rule
    //         [['birthdate', 'created_at', 'updated_at'], 'safe'],
    //         [['languages'], 'required'],
    //         [['languages'], 'safe'],
    //         [['first_name', 'middle_name', 'last_name', 'full_name', 'nick_name', 'city', 'country', 'timezone'], 'string', 'max' => 100],
    //         [['phone_number'], 'string', 'max' => 20],
    //         [['avatarFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'], // Rule for file upload
    //     ];
    // }

    public function rules()
{
    return [
        [['user_id', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
        [['gender', 'address', 'avatar_url'], 'string'],
        [['full_name', 'nick_name', 'gender','country','phone_number'], 'required'],
        [['birthdate', 'created_at', 'updated_at'], 'safe'],
        [['languages'], 'required'],
        [['languages'], 'safe'],

        // Name fields (1 to 100 characters)
        [['first_name', 'middle_name', 'last_name', 'full_name', 'nick_name', 'city', 'country', 'timezone'], 'string', 'min' => 2, 'max' => 100],

        // Phone number validation: max 20 characters, digits, optional + or - 
        ['phone_number', 'match', 'pattern' => '/^\+?[0-9\-]{7,20}$/', 'message' => 'Invalid phone number format.'],

        // Avatar file upload: image only, max size 2MB
        ['avatarFile', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024 * 1024, 'tooBig' => 'Profile image size must not exceed 2MB.'],
    ];
}


    /**
     * Uploads the image to the `uploads/` directory.
     *
     * @return bool|string the file path if upload was successful, false otherwise.
     */
    // public function uploadAvatar()
    // {
    //     $username = Yii::$app->user->identity->username;
    //     if ($this->validate() && $this->avatarFile) {
    //         $path = 'assets/uploads/avatars/';
    //         if (!file_exists($path)) {
    //             mkdir($path, 0777, true);
    //         }

    //         $filePath =  $path . $username . '_' . time() . '.' . $this->avatarFile->extension;
    //         $savedFile = $this->avatarFile->saveAs($filePath);
    //         if ($savedFile) {
    //             return $filePath;
    //         }
    //     }
    //     return false;
    // }

    public function uploadAvatar()
{
    $username = Yii::$app->user->identity->username;

    if ($this->avatarFile) {
        $path = 'uploads/avatars/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fileName = str_replace(' ', '_', $username) . '_' . time() . '.' . $this->avatarFile->extension;
        $filePath = $path . $fileName;

        if ($this->avatarFile->saveAs($filePath)) {
            return '/' . $filePath; // prepend / for web access
        }
    }

    return false;
}


    public static function profile_completed()
{
    $userId = Yii::$app->user->id;
    $profile = Profiles::findOne(['user_id' => $userId]);

    return $profile && $profile->full_name && $profile->phone_number;
}






}
