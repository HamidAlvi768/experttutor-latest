<?php

namespace app\controllers;

use app\components\Helper;
use app\models\ApplyCoin;
use app\models\ChatMessages;
use app\models\PostMessages;
use app\models\StudentJobPosts;
use app\models\User;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\web\Response;
use Yii;


class ChatController extends Controller
{
    public function beforeAction($action)
    {
        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error'];

        // Check if user is guest and trying to access restricted area
        if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
            Yii::$app->session->setFlash('error', 'Please login to access this page.');
            if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'student'){
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
            }
            Yii::$app->response->redirect(['/login'])->send();
            return false;
        }

        // Role-based access control
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $userRole = $user->role;

            // check user verificaiton
            if (!$user->verification && ($actionId != "verification" && $actionId != "verify")) {
                return $this->redirect(['/verification']);
            }
            if (!$user->profile && $userRole='student' && ($actionId != "verification" && $actionId != "verify")) {
                Yii::$app->session->setFlash('error', 'Please complete your profile before accessing this page.');
                return $this->redirect(['/profile/create'])->send();
            }

            // Define role-specific permissions
            $permissions = [
                'superadmin' => ['*'],
                'admin' => ['*'],
                'tutor' => ['chat', 'peoples', 'upload-attachment','check-conversation'],
                'student' => ['chat', 'peoples', 'upload-attachment','check-conversation'],
            ];

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
                Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                return $this->redirect(['site/index']);
            }
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'upload-attachment' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPeoples()
    {
        $myId = Yii::$app->user->identity->id;


$lastMsgSender = new \yii\db\Expression("
    (
        SELECT cm2.sender_id
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$lastMsgReceiver = new \yii\db\Expression("
    (
        SELECT cm2.receiver_id
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$lastMsgRole = new \yii\db\Expression("
    (
        SELECT cm2.role
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$peoples = (new \yii\db\Query())
    ->select([
        'u.id',
        'u.username',
        'u.email',
        'u.role',
        'u.user_slug',
        'unread_count' => new \yii\db\Expression("
            SUM(
                CASE 
                    WHEN cm.receiver_id = :myId 
                         AND cm.is_read = 0 
                    THEN 1 ELSE 0 
                END
            )
        "),
        'last_time' => new \yii\db\Expression("MAX(cm.created_at)"),
        'last_msg' => new \yii\db\Expression("
            (
                SELECT cm2.message
                FROM chat_messages cm2
                WHERE 
                    (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
                    OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
                ORDER BY cm2.created_at DESC
                LIMIT 1
            )
        "),
        'last_msg_sender' => $lastMsgSender,
        'last_msg_receiver' => $lastMsgReceiver,
        'last_msg_role' => $lastMsgRole,
    ])
    ->from(['u' => 'users'])
    ->innerJoin(['cm' => 'chat_messages'], 'u.id = cm.sender_id OR u.id = cm.receiver_id')
    ->innerJoin(['sender' => 'users'], 'sender.id = cm.sender_id')
    ->innerJoin(['receiver' => 'users'], 'receiver.id = cm.receiver_id')
    ->where([
        'or',
        ['cm.sender_id' => $myId],
        ['cm.receiver_id' => $myId],
    ])
    ->andWhere(['!=', 'u.id', $myId])

    // ✅ Re-use same subqueries instead of alias
    ->andWhere([
        'or',
        [
            'and',
            new \yii\db\Expression("$lastMsgSender = :myId"),
            new \yii\db\Expression("sender.role = $lastMsgRole"),
        ],
        [
            'and',
            new \yii\db\Expression("$lastMsgReceiver = :myId"),
            new \yii\db\Expression("receiver.role != $lastMsgRole"),
        ],
    ])

    ->groupBy(['u.id', 'u.username', 'u.email', 'u.role'])
    ->orderBy(new \yii\db\Expression('MAX(cm.created_at) DESC'))
    ->params([':myId' => $myId])
    ->all();




        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }


        return $this->render('peoples', [
            'peoples' => $peoples,
        ]);
    }

    public function actionChat()
    {
        $secretKey = "random1000secret1000keys";
        $otherId = Yii::$app->request->get("other");
        $otherId = Helper::getuseridfromslug($otherId);
        $myId = Yii::$app->user->identity->id;
        $postId = Yii::$app->request->get("post");

        $post = null;
        if (!empty($postId)) {
            $post = StudentJobPosts::findOne($postId);
        }

        // $other = User::findOne($otherId);

$other = User::find()
    ->alias('u')
    ->select(['u.*', 'ull.left_at AS last_seen'])
    ->leftJoin(['ull' => 'user_leave_log'], 'u.id = ull.user_id')
    ->where(['u.id' => $otherId])
    ->orderBy(['ull.left_at' => SORT_DESC])
    ->limit(1)
    ->one(); // returns ActiveRecord object



        $messages = ChatMessages::find()
            ->with(['sender'])
            ->where([
                'or',
                ['and', ['sender_id' => $otherId], ['receiver_id' => $myId]],
                ['and', ['sender_id' => $myId], ['receiver_id' => $otherId]]
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();


$lastMsgSender = new \yii\db\Expression("
    (
        SELECT cm2.sender_id
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$lastMsgReceiver = new \yii\db\Expression("
    (
        SELECT cm2.receiver_id
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$lastMsgRole = new \yii\db\Expression("
    (
        SELECT cm2.role
        FROM chat_messages cm2
        WHERE 
            (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
            OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
        ORDER BY cm2.created_at DESC
        LIMIT 1
    )
");

$peoples = (new \yii\db\Query())
    ->select([
        'u.id',
        'u.username',
        'u.email',
        'u.role',
        'u.user_slug',
        'unread_count' => new \yii\db\Expression("
            SUM(
                CASE 
                    WHEN cm.receiver_id = :myId 
                         AND cm.is_read = 0 
                    THEN 1 ELSE 0 
                END
            )
        "),
        'last_time' => new \yii\db\Expression("MAX(cm.created_at)"),
        'last_msg' => new \yii\db\Expression("
            (
                SELECT cm2.message
                FROM chat_messages cm2
                WHERE 
                    (cm2.sender_id = u.id AND cm2.receiver_id = :myId)
                    OR (cm2.sender_id = :myId AND cm2.receiver_id = u.id)
                ORDER BY cm2.created_at DESC
                LIMIT 1
            )
        "),
        'last_msg_sender' => $lastMsgSender,
        'last_msg_receiver' => $lastMsgReceiver,
        'last_msg_role' => $lastMsgRole,
    ])
    ->from(['u' => 'users'])
    ->innerJoin(['cm' => 'chat_messages'], 'u.id = cm.sender_id OR u.id = cm.receiver_id')
    ->innerJoin(['sender' => 'users'], 'sender.id = cm.sender_id')
    ->innerJoin(['receiver' => 'users'], 'receiver.id = cm.receiver_id')
    ->where([
        'or',
        ['cm.sender_id' => $myId],
        ['cm.receiver_id' => $myId],
    ])
    ->andWhere(['!=', 'u.id', $myId])

    // ✅ Re-use same subqueries instead of alias
    ->andWhere([
        'or',
        [
            'and',
            new \yii\db\Expression("$lastMsgSender = :myId"),
            new \yii\db\Expression("sender.role = $lastMsgRole"),
        ],
        [
            'and',
            new \yii\db\Expression("$lastMsgReceiver = :myId"),
            new \yii\db\Expression("receiver.role != $lastMsgRole"),
        ],
    ])

    ->groupBy(['u.id', 'u.username', 'u.email', 'u.role'])
    ->orderBy(new \yii\db\Expression('MAX(cm.created_at) DESC'))
    ->params([':myId' => $myId])
    ->all();




        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }
        return $this->render('peoples', [
            'messages' => $messages,
            'peoples' => $peoples,
            'other' => $other,
            'post' => $post
        ]);
    }



public function actionCheckConversation($otherId)
{
    Yii::$app->response->format = Response::FORMAT_JSON;
    $currentUserId = Yii::$app->user->id;
    $userRole = Yii::$app->user->identity->role;

    // if ($userRole != 'tutor') {
    //     return $this->asJson([
    //         'allowed' => true,
    //         'chatUrl' => \app\components\Helper::baseUrl("/peoples/chat?other={$otherId}"),
    //         'coinsRequired' => 0,
    //     ]);
    // }

    $r_otherId= Helper::getuseridfromslug($otherId);
    $isAllowed = Helper::hasActiveJobConversation($r_otherId, $currentUserId);


    // Build query
    $query = ApplyCoin::find();
    $query->where(['country' => 'default']);
    $applyCoin = $query->one();
    $coinsRequired = $applyCoin ? $applyCoin->coin_value : 0;

    return $this->asJson([
        'allowed' => $isAllowed,
        'chatUrl' => \app\components\Helper::baseUrl("/peoples/chat?other={$otherId}"),
        'coinsRequired' => $coinsRequired, // example
    ]);
}


    public function actionUploadAttachment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            // Log the request for debugging
            Yii::info('Upload attachment request received', 'chat');
            
            $file = UploadedFile::getInstanceByName('file');
            
            if (!$file) {
                Yii::error('No file uploaded', 'chat');
                return ['success' => false, 'message' => 'No file uploaded'];
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'text/plain'];
            if (!in_array($file->type, $allowedTypes)) {
                return ['success' => false, 'message' => 'File type not allowed'];
            }

            // Validate file size (5MB limit)
            if ($file->size > 5 * 1024 * 1024) {
                return ['success' => false, 'message' => 'File size too large (max 5MB)'];
            }

            // Create upload directory if it doesn't exist
            $uploadDir = Yii::getAlias('@webroot/uploads/chat-attachments/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = $file->extension;
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            // Save file
            if ($file->saveAs($filepath)) {
                $relativePath = 'uploads/chat-attachments/' . $filename;
                
                Yii::info('File uploaded successfully: ' . $filename, 'chat');
                
                return [
                    'success' => true,
                    'filename' => $filename,
                    'filepath' => $relativePath,
                    'originalName' => $file->baseName . '.' . $file->extension,
                    'size' => $file->size,
                    'type' => $file->type
                ];
            } else {
                Yii::error('Failed to save file: ' . $filepath, 'chat');
                return ['success' => false, 'message' => 'Failed to save file'];
            }
            
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()];
        }
    }
}
