<?php
namespace app\components;

use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;

class JwtHelper
{
    private static $key = 'y7sDF!j#0Pz8Kw@12LqX9e*fTgBv4Cxz'; // Use a strong key
    private static $algo = 'HS256';
    private static $jwtEnabled = false;

    public static function setJwtEnabled($value)
    {
        self::$jwtEnabled = (bool) $value;
    }

    public static function isJwtEnabled()
    {
        return self::$jwtEnabled;
    }

    /**
     * Generates access & refresh token pair and stores refresh token in DB.
     */
    public static function generateTokens($userId)
    {
        $accessPayload = [
            'iss' => 'http://experttutor/',
            'aud' => 'your-app-user',
            'iat' => time(),
            'exp' => time() + (60 * 60), // 1 hour expiry
            'uid' => $userId
        ];

        $refreshToken = bin2hex(random_bytes(32)); // 64-char secure token

        $user = User::findOne($userId);
        if ($user) {
            $user->refresh_token = $refreshToken;
            $user->save(false);
        }

        return [
            'access_token' => JWT::encode($accessPayload, self::$key, self::$algo),
            'refresh_token' => $refreshToken
        ];
    }

    /**
     * Validates the token and returns decoded object.
     */
    public static function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$key, self::$algo));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Returns the current logged-in user using access token.
     */
    public static function getUserFromToken()
    {
        if (!self::isJwtEnabled()) {
            return true;
        }

        $authHeader = Yii::$app->request->getHeaders()->get('access_token');
        if ($authHeader && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
            try {
                $decoded = JWT::decode($token, new Key(self::$key, self::$algo));
                return User::findOne($decoded->uid);
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Use this to refresh token using a valid refresh token.
     */
    public static function refreshAccessToken($refreshToken)
    {
        $user = User::find()->where(['refresh_token' => $refreshToken])->one();

        if ($user) {
            return self::generateTokens($user->id);
        }

        return false;
    }

    /**
     * Use this to directly get refresh token for a user by ID.
     */
    public static function getRefreshTokenForUser($userId)
    {
        $user = User::findOne($userId);
        return $user ? $user->refresh_token : null;
    }
}
