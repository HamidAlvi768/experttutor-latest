<?php
namespace app\components;

use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;

class JwtHelper
{
    private static $key = 'y7sDF!j#0Pz8Kw@12LqX9e*fTgBv4Cxz'; // 🔐 Change this to something secure
    private static $algo = 'HS256';

    // ✅ Control token validation here
    private static $jwtEnabled = true;

        // Call this to enable/disable in runtime if needed
    public static function setJwtEnabled($value)
    {
        self::$jwtEnabled = (bool) $value;
    }

    public static function isJwtEnabled()
    {
        return self::$jwtEnabled;
    }


    public static function generateToken($userId)
    {
        $payload = [
            'iss' => 'http://experttutor/',           // Issuer
            'aud' => 'your-app-user',      // Audience
            'iat' => time(),               // Issued at
            'exp' => time() + (60 * 60),   // Token expires in 1 hour
            'uid' => $userId               // User ID payload
        ];

        return JWT::encode($payload, self::$key, self::$algo);
    }

    public static function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, self::$algo));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
     public static function getUserFromToken()
    {
        if (!self::isJwtEnabled()) {
            // JWT is disabled globally
            return true; // Or return a dummy user if needed
        }

        $authHeader = Yii::$app->request->getHeaders()->get('Authorization');

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

    

}
