<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\Response;

class SseHeadersBehavior extends Behavior
{
    // This method will set the necessary headers for SSE
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setSseHeaders',
        ];
    }

    // Method to set the headers for SSE
    public function setSseHeaders($event)
    {
        // Set response format to raw (not JSON or HTML)
        Yii::$app->response->format = Response::FORMAT_RAW;

        // Set headers for SSE
        Yii::$app->response->headers->add('Content-Type', 'text/event-stream');
        Yii::$app->response->headers->add('Cache-Control', 'no-cache');
        Yii::$app->response->headers->add('Connection', 'keep-alive');
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'GET');

        // Log for debugging (Optional)
        Yii::info('SSE headers set', __METHOD__);
    }
}
