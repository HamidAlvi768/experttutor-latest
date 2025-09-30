<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "general_setting".
 *
 * @property int $id
 * @property string|null $site_name
 * @property string|null $email
 * @property string|null $contacts
 * @property string|null $host
 * @property string|null $port
 * @property string|null $username
 * @property string|null $password
 * @property string|null $sender_email
 * @property string|null $receiver_email
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $active
 */
class GeneralSetting extends \yii\db\ActiveRecord
{

          /**
     * @var UploadedFile
     */
    public $documentsFile;  // Add this line to handle the file upload
    public $documentsFile2;  // Add this line to handle the file upload


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'general_setting';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['created_at', 'updated_at', 'updated_at', 'created_by', 'updated_by', 'active'], 'safe'],
    //        // [['updated_at', 'created_by', 'updated_by', 'active'], 'required'],
    //         [['created_by', 'updated_by', 'active'], 'integer'],
    //         [['site_name', 'email', 'contacts', 'host', 'port', 'username', 'password', 'sender_email', 'receiver_email'], 'string', 'max' => 255],
    //     ];
    // }
public function rules()
{
    return [
        // Required fields
        [['site_name', 'email', 'contacts', 'host', 'port','smtpsecure', 'username', 'password', 'sender_email', 'receiver_email'], 'required'],

        // Integer fields
        [['created_by', 'updated_by', 'active'], 'integer'],

        // Safe date fields
        [['created_at', 'updated_at','site_logo','social_fb','social_tw','social_ig','social_yt','social_li','site_logo_white'], 'safe'],

        // String length constraints
        [['site_name', 'host', 'username', 'password', 'smtpsecure'], 'string', 'min' => 3, 'max' => 255],

        // Email validation
        [['email', 'sender_email', 'receiver_email'], 'email'],

        // Port validation: digits only, length 2-5
        ['port', 'match', 'pattern' => '/^\d{2,5}$/', 'message' => 'Port must be a number between 2 and 5 digits.'],

        // Contacts: allow digits, +, (), spaces, and dashes
       ['contacts', 'match', 'pattern' => '/^(\+?\d{1,4})?[\s\-]?\d{7,15}$/', 'message' => 'Enter a valid contact number.'],

        [
            ['site_logo','site_logo_white'], 
            'file', 
            'skipOnEmpty' => true, 
            'extensions' => 'png, jpg, jpeg', // allowed file types
            'maxSize' => 1024 * 1024 * 2, // 2 MB
            'wrongExtension' => 'Only {extensions} files are allowed.',
            'tooBig' => 'File size cannot exceed 2MB.'
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
            'site_name' => 'Site Name',
            'email' => 'Email',
            'contacts' => 'Contacts',
            'host' => 'Host',
            'port' => 'Port',
            'smtpsecure'=>'SMTP Secure',
            'username' => 'Username',
            'password' => 'Password',
            'sender_email' => 'Sender Email',
            'receiver_email' => 'Receiver Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'active' => 'Active',
        ];
    }


    
    public function uploadAvatar()
{
    $username = Yii::$app->user->identity->username;

    if ($this->documentsFile) {
        $path = 'uploads/site-logo/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

      

        $fileName = str_replace(' ', '_', $username) . '_' . time().uniqid() . '.' . $this->documentsFile->extension;
        $filePath = $path . $fileName;

        if ($this->documentsFile->saveAs($filePath)) {
            return '/' . $filePath; // prepend / for web access
        }
    }
    

    return false;
}

    public function uploadAvatar2()
{
    //sleep(1); // Add a 2-second delay
    $username = Yii::$app->user->identity->username;

    if ($this->documentsFile2) {
        $path = 'uploads/site-logo/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

     

        $fileName = str_replace(' ', '_', $username) . '_' . time().uniqid() . '.' . $this->documentsFile2->extension;
        $filePath = $path . $fileName;

        if ($this->documentsFile2->saveAs($filePath)) {
            return '/' . $filePath; // prepend / for web access
        }
    }
    

    return false;
}



}
