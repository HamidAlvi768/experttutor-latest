<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['active' => 1],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send.
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'active' => 1,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $site_setting = \app\models\GeneralSetting::find()->one();
        $resetLink = \app\components\Helper::baseUrl() . 'site/reset-password?token=' . $user->password_reset_token;

        return \app\components\Mail::send(
            $user->email,
            'Password reset for ' . ($site_setting->site_name ?? 'Assignlly') . ' ' . date("F d, Y H:i"),
            'mail/passwordResetToken-html.php',
            [
                'user' => $user,
                'resetLink' => $resetLink,
            ]
        );
    }
} 