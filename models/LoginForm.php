<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            if ($user->active === 1) {
                // check hash password
                if (Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                    return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
                } else {
                    $this->addError('password', 'Incorrect password.');
                }
            } else {
                $this->addError('email', 'Your account is not active. Please contact support.');
            }
        } else {
            $this->addError('email', 'Invalid email or password.');
        }
        return false;
    }

    public function validatePassword($attribute, $params) {}

    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where(['email' => $this->email])->one();
        }

        return $this->_user;
    }
}
