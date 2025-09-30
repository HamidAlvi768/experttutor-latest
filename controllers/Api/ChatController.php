<?php

namespace app\controllers\api;

use app\components\JwtHelper;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;
use app\models\ChatMessages;
use app\models\StudentJobPosts;
use app\models\User;
use yii\web\UploadedFile;

class ChatController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Set JSON response format
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        

        return $behaviors;
    }

       public function beforeAction($action)
{
    // Set response to JSON for API
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $actionId = $action->id;
    $controllerId = $this->id;

    // Actions accessible without login
    $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error'];

    // Case 1: Guest trying to access restricted action
    if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
        Yii::$app->response->statusCode = 401;
        Yii::$app->response->data = [
            'success' => false,
            'message' => 'Please login to access this resource.'
        ];
        return false;
    }

    // Case 2: Logged-in user
    if (!Yii::$app->user->isGuest) {
        $user = Yii::$app->user->identity;
        $userRole = $user->role;

        // Case 2a: User not verified and trying to access other actions
        if (!$user->verification && !in_array($actionId, ['verification', 'verify'])) {
            Yii::$app->response->statusCode = 403;
            Yii::$app->response->data = [
                'success' => false,
                'message' => 'Account not verified. Please verify your account first.'
            ];
            return false;
        }

        // Case 2b: Role-based permissions
        // $permissions = [
        //     'superadmin' => ['*'],
        //     'admin' => ['*'],
        //     'tutor' => ['verify-phone', 'view', 'create', 'update'],
        //     'student' => ['verify-phone', 'view', 'create', 'update'],
        // ];

        // // Check permission
        // if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
        //     Yii::$app->response->statusCode = 403;
        //     Yii::$app->response->data = [
        //         'success' => false,
        //         'message' => 'You do not have permission to access this resource.'
        //     ];
        //     return false;
        // }
    }

    // If all checks pass
    return parent::beforeAction($action);
}

    // GET /chat/peoples
    public function actionPeoples()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $myId = Yii::$app->user->id;

        $peoples = (new \yii\db\Query())
            ->select(['u.id', 'u.username', 'u.email', 'u.role'])
            ->from(['u' => 'users'])
            ->innerJoin(['cm' => 'chat_messages'], 'u.id = cm.sender_id OR u.id = cm.receiver_id')
            ->where(['or', ['cm.sender_id' => $myId], ['cm.receiver_id' => $myId]])
            ->andWhere(['!=', 'u.id', $myId])
            ->distinct()
            ->all();

        return [
            'success' => true,
            'data' => $peoples,
        ];
    }

    // GET /chat/chat?other=USER_ID&post=POST_ID (post is optional)
    public function actionChat($other, $post = null)
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $myId = Yii::$app->user->id;

        $otherUser = User::findOne($other);
        if (!$otherUser) {
            return [
                'success' => false,
                'error' => 'User not found',
            ];
        }

        $postModel = null;
        if (!empty($post)) {
            $postModel = StudentJobPosts::findOne($post);
        }

        $messages = ChatMessages::find()
            ->select(['id', 'job_post_id', 'sender_id', 'receiver_id', 'message', 'attachment', 'is_read', 'active', 'deleted', 'created_at', 'updated_at', 'created_by', 'updated_by'])
            ->with('sender')
            ->where([
                'or',
                ['and', ['sender_id' => $other], ['receiver_id' => $myId]],
                ['and', ['sender_id' => $myId], ['receiver_id' => $other]]
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();

        // Debug: Log first message to see structure
        if (!empty($messages)) {
            Yii::info('=== LOADING MESSAGES ===', 'chat');
            Yii::info('Total messages found: ' . count($messages), 'chat');
            Yii::info('First message structure: ' . json_encode($messages[0]), 'chat');
            
            // Check for messages with attachments
            $messagesWithAttachments = array_filter($messages, function($msg) {
                return !empty($msg['attachment']);
            });
            Yii::info('Messages with attachments: ' . count($messagesWithAttachments), 'chat');
            
            if (!empty($messagesWithAttachments)) {
                Yii::info('Sample message with attachment: ' . json_encode(array_values($messagesWithAttachments)[0]), 'chat');
            }
        }
        
        return [
            'success' => true,
            'other_user' => [
                'id' => $otherUser->id,
                'username' => $otherUser->username,
                'email' => $otherUser->email,
                'role' => $otherUser->role,
            ],
            'post' => $postModel,
            'messages' => $messages,
        ];
    }

    // POST /chat/send-message
    public function actionSendMessage()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $myId = Yii::$app->user->id;
        $request = Yii::$app->request;

        $receiverId = $request->post('receiver_id');
        $message = $request->post('message');
        $postId = $request->post('post_id'); // optional
        $attachment = $request->post('attachment'); // optional
        
        // Debug logging
        Yii::info('=== API RECEIVED DATA ===', 'chat');
        Yii::info('API received attachment: ' . $attachment, 'chat');
        Yii::info('API received message: ' . $message, 'chat');
        Yii::info('API received receiver_id: ' . $receiverId, 'chat');
        Yii::info('API received post_id: ' . $postId, 'chat');
        Yii::info('Full POST data: ' . json_encode($request->post()), 'chat');
        
        // Check if this is a file upload request
        $uploadedFile = UploadedFile::getInstanceByName('attachment');
        if ($uploadedFile) {
            Yii::info('File upload detected: ' . $uploadedFile->name, 'chat');
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'text/plain'];
            if (!in_array($uploadedFile->type, $allowedTypes)) {
                return ['success' => false, 'error' => 'File type not allowed'];
            }

            // Validate file size (5MB limit)
            if ($uploadedFile->size > 5 * 1024 * 1024) {
                return ['success' => false, 'error' => 'File size too large (max 5MB)'];
            }

            // Create upload directory if it doesn't exist
            $uploadDir = Yii::getAlias('@webroot/uploads/chat-attachments/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = $uploadedFile->extension;
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            // Save file
            if ($uploadedFile->saveAs($filepath)) {
                $attachment = 'uploads/chat-attachments/' . $filename;
                Yii::info('File saved successfully: ' . $attachment, 'chat');
            } else {
                Yii::error('Failed to save file: ' . $filepath, 'chat');
                return ['success' => false, 'error' => 'Failed to save file'];
            }
        }

        if (empty($receiverId) || empty($message)) {
            return [
                'success' => false,
                'error' => 'receiver_id and message are required.',
            ];
        }

        $receiver = User::findOne($receiverId);
        if (!$receiver) {
            return [
                'success' => false,
                'error' => 'Receiver not found.',
            ];
        }

        $chat = new ChatMessages();
        $chat->sender_id = $myId;
        $chat->receiver_id = $receiverId;
        $chat->message = $message;
        $chat->attachment = $attachment ?? null;
        $chat->job_post_id = $postId ?? null;
        $chat->created_at = date('Y-m-d H:i:s');
        
        // Debug logging
        Yii::info('=== SAVING MESSAGE ===', 'chat');
        Yii::info('Saving chat message with attachment: ' . $chat->attachment, 'chat');
        Yii::info('Chat model attributes: ' . json_encode($chat->attributes), 'chat');

        if ($chat->save()) {
            Yii::info('Message saved successfully', 'chat');
            Yii::info('Saved message ID: ' . $chat->id, 'chat');
            Yii::info('Saved attachment: ' . $chat->attachment, 'chat');
            return [
                'success' => true,
                'message' => 'Message sent successfully.',
                'data' => $chat,
            ];
        }

        return [
            'success' => false,
            'error' => 'Failed to send message.',
            'details' => $chat->getErrors(),
        ];
    }
}
