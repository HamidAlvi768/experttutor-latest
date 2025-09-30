<?php

namespace app\controllers;

use app\components\Helper;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\ChatMessages;
use app\models\User;

class ApiController extends Controller
{
    // Disable CSRF validation for API endpoints
    public $enableCsrfValidation = false;

    /**
     * Handle CORS preflight requests and set headers
     */
    public function beforeAction($action)
    {
        // Handle OPTIONS preflight request
        if (Yii::$app->request->isOptions) {
            Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
            Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'POST, OPTIONS');
            Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type');
            Yii::$app->response->statusCode = 204; // No content
            return false; // Stop further processing
        }

        // Set CORS headers for all responses
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');

        return parent::beforeAction($action);
    }

    // public function actionMessages()
    // {
    //     // Handle OPTIONS preflight request
    //     if (Yii::$app->request->isOptions) {
    //         Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
    //         Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'POST, OPTIONS');
    //         Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type');
    //         Yii::$app->response->statusCode = 204; // No content
    //         return false; // Stop further processing
    //     }

    //     // Set CORS headers for all responses
    //     Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');

    //     // Set response format to JSON
    //     Yii::$app->response->format = Response::FORMAT_JSON;
    //     $otherId = Yii::$app->request->get("other");
    //     $myId = Yii::$app->user->identity->id;
    //     $postId = Yii::$app->request->get("post");

    //     $other = User::findOne($otherId);

    //     $messages = ChatMessages::find()
    //         ->with(['sender'])
    //         ->where([
    //             'or',
    //             ['and', ['sender_id' => $otherId], ['receiver_id' => $myId]],
    //             ['and', ['sender_id' => $myId], ['receiver_id' => $otherId]]
    //         ])
    //         ->orderBy(['created_at' => SORT_ASC])
    //         ->all();


    //     $peoples = (new \yii\db\Query())
    //         ->select(['u.id', 'u.username', 'u.email', 'u.role'])
    //         ->from(['u' => 'users'])
    //         ->innerJoin(
    //             ['cm' => 'chat_messages'],
    //             'u.id = cm.sender_id OR u.id = cm.receiver_id'
    //         )
    //         ->where([
    //             'or',
    //             ['cm.sender_id' => $myId],
    //             ['cm.receiver_id' => $myId]
    //         ])
    //         ->andWhere(['!=', 'u.id', $myId]) // Exclude myself
    //         ->distinct()
    //         ->all();


    //     return [
    //         'messages' => array_map(function ($message) {
    //             return [
    //                 'message' => $message,
    //                 'sender' => [
    //                     'username' => $message->sender->username,
    //                     'id' => $message->sender->id,
    //                 ],
    //             ];
    //         }, $messages),
    //         'peoples' => $peoples,
    //         'other' => $other
    //     ];
    // }

    public function actionMessages()
{
    // Handle OPTIONS preflight request
    if (Yii::$app->request->isOptions) {
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'POST, OPTIONS');
        Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type');
        Yii::$app->response->statusCode = 204; // No content
        return false;
    }

    // Set CORS headers
    Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
    Yii::$app->response->format = Response::FORMAT_JSON;

    $otherId = Yii::$app->request->get("other");

    $myId = Yii::$app->user->identity->id;
    $postId = Yii::$app->request->get("post");

    $other = User::findOne($otherId);

    //Fetch messages for this conversation
    $messages = ChatMessages::find()
        ->with(['sender'])
        ->where([
            'or',
            ['and', ['sender_id' => $otherId], ['receiver_id' => $myId]],
            ['and', ['sender_id' => $myId], ['receiver_id' => $otherId]]
        ])
        ->orderBy(['created_at' => SORT_ASC])
        ->all();
    // $myRole = Yii::$app->user->identity->role;
    // $oposite = ($myRole == "tutor") ? "student" : "tutor";

    // $messages = ChatMessages::find()
    //     ->with(['sender'])
    //     ->where([
    //         'or',
    //         // Messages I sent (should have my role)
    //         ['and', ['sender_id' => $myId, 'receiver_id' => $otherId, 'role' => $myRole]],
    //         // Messages they sent (should have opposite role)
    //         ['and', ['sender_id' => $otherId, 'receiver_id' => $myId, 'role' => $oposite]]
    //     ])
    //     ->orderBy(['created_at' => SORT_ASC])
    //     ->all();


    // ✅ Mark as read for messages from the other person to me
    $unreadIds = \yii\helpers\ArrayHelper::getColumn(
        array_filter($messages, function ($msg) use ($myId, $otherId) {
            return $msg->sender_id == $otherId && $msg->receiver_id == $myId && $msg->is_read == 0;
        }),
        'id'
    );

    if (!empty($unreadIds)) {
        ChatMessages::updateAll(['is_read' => 1], ['id' => $unreadIds]);
    }

    // Get all conversation partners
    $peoples = (new \yii\db\Query())
        ->select(['u.id', 'u.username', 'u.email', 'u.role'])
        ->from(['u' => 'users'])
        ->innerJoin(
            ['cm' => 'chat_messages'],
            'u.id = cm.sender_id OR u.id = cm.receiver_id'
        )
        ->where([
            'or',
            ['cm.sender_id' => $myId],
            ['cm.receiver_id' => $myId]
        ])
        ->andWhere(['!=', 'u.id', $myId]) // Exclude myself
        ->distinct()
        ->all();

    return [
        'messages' => array_map(function ($message) {
            return [
                'message' => $message,
                'sender' => [
                    'username' => $message->sender->username,
                    'id' => $message->sender->id,
                ],
            ];
        }, $messages),
        'peoples' => $peoples,
        'other' => $other
    ];
}

    public function actionAddMessage()
    {
         $id = Yii::$app->user->identity->id;
        // Handle OPTIONS preflight request
        if (Yii::$app->request->isOptions) {
            Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
            Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'POST, OPTIONS');
            Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Content-Type');
            Yii::$app->response->statusCode = 204; // No content
            return false; // Stop further processing
        }

        // Set CORS headers for all responses
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');

        // Set response format to JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get the raw POST data
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return [
                'success' => false,
                'message' => 'Only POST requests are allowed',
            ];
        }

        // Parse JSON payload
        $data = $request->getRawBody();
        $params = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'Invalid JSON payload',
            ];
        }

        // Validate required fields
        if (empty($params['sender_id']) || empty($params['receiver_id']) || empty($params['message'])) {
            return [
                'success' => false,
                'message' => 'Missing required fields: sender_id, receiver_id, or message',
            ];
        }

        $postId = (int)$params['job_post_id'];
        // Create new ChatMessages instance
        $chatMessage = new ChatMessages();
        $chatMessage->sender_id = (int)$params['sender_id'];
        $chatMessage->receiver_id = (int)$params['receiver_id'];
        $chatMessage->message = $params['message'];
        $chatMessage->role  = Yii::$app->user->identity->role;
        $chatMessage->created_at = date('Y-m-d H:i:s'); // Current timestamp

        if ($postId > 0) {
            $chatMessage->job_post_id = $postId;
        }

        $foundPostMessage = ChatMessages::find()->where(['job_post_id' => $postId])->andWhere(['sender_id' => $id])->one();
        if (!$foundPostMessage) {
            // Save the message
            $savedMessage = $chatMessage->save();

            if ($savedMessage) {
                return [
                    'success' => true,
                    'message' => 'Message added successfully',
                    'data' => [
                        'id' => $chatMessage->id,
                        'sender_id' => $chatMessage->sender_id,
                        'receiver_id' => $chatMessage->receiver_id,
                        'message' => $chatMessage->message,
                        'created_at' => $chatMessage->created_at,
                    ],
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to save message',
                    'errors' => $chatMessage->getErrors(),
                ];
            }
        } else {
            return [
                'success' => true,
                'message' => 'Already Saved',
                'errors' => "no",
            ];
        }
    }

    /**
     * Define behaviors (optional: add authentication if needed)
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }
}
