<?php

namespace app\controllers;

use app\models\ChatMessages;
use Exception;
use Yii;
use yii\web\Controller;

class SseController extends Controller
{
    public function beforeAction($action)
    {
        // Disable CSRF, session, and logging
        $this->enableCsrfValidation = false;
        Yii::$app->session->close();
        Yii::$app->log->targets = [];

        // Clear output buffers
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Manually set headers (bypass Yii’s Response object)
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('Access-Control-Allow-Origin: *');

        // Debug: Log headers to file
        // file_put_contents(__DIR__ . '/debug.txt', "BeforeAction Headers: " . implode("\n", headers_list()) . "\n\n", FILE_APPEND);

        return parent::beforeAction($action);
    }

    public function actionChat()
    {
        $myId = Yii::$app->request->get('myId');
        $otherId = Yii::$app->request->get('otherId');

        echo "retry: 5000\n";
        flush();

        try {

            $timeThreshold = date('Y-m-d H:i:s', strtotime('-5 second')); // 30 minutes ago

            $messages = ChatMessages::find()
                ->with(['sender'])
                ->where(['and',['sender_id' => $otherId], ['receiver_id' => $myId]])
                ->andWhere(['>=', 'created_at', $timeThreshold]) // Last 30 minutes
                ->orderBy(['created_at' => SORT_ASC])
                ->all();

            foreach ($messages as $message) {
                echo "data: " . json_encode([
                    'sender_id' => $message->sender->id,
                    'sender' => $message->sender->username,
                    'message' => $message->message,
                    'created_at' => $message->created_at,
                ]) . "\n\n";
                flush();
            }
        } catch (Exception $e) {
            echo "event: error\ndata: " . json_encode(['error' => 'Server error']) . "\n\n";
            flush();
        }

        exit(0);
    }
    public function actionChatOldMethod()
    {
        $myId = Yii::$app->request->get('myId');
        $otherId = Yii::$app->request->get('otherId');

        echo "retry: 10000\n";
        flush();

        try {

            $timeThreshold = date('Y-m-d H:i:s', strtotime('-5 second')); // 30 minutes ago

            $messages = ChatMessages::find()
                ->with(['sender'])
                ->where([
                    'or',
                    ['and', ['sender_id' => $otherId], ['receiver_id' => $myId]],
                    ['and', ['sender_id' => $myId], ['receiver_id' => $otherId]]
                ])
                ->andWhere(['>=', 'created_at', $timeThreshold]) // Last 30 minutes
                ->orderBy(['created_at' => SORT_ASC])
                ->all();

            foreach ($messages as $message) {
                echo "data: " . json_encode([
                    'sender_id' => $message->sender->id,
                    'sender' => $message->sender->username,
                    'message' => $message->message,
                    'created_at' => $message->created_at,
                ]) . "\n\n";
                flush();
            }
        } catch (Exception $e) {
            echo "event: error\ndata: " . json_encode(['error' => 'Server error']) . "\n\n";
            flush();
        }

        exit(0);
    }
}
