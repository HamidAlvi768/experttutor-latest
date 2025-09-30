<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use app\components\Helper;
use app\components\JwtHelper;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Return JSON responses
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

    /**
     * Initiates a Stripe payment.
     * POST /api/payment/stripe-payment
     */
    public function actionStripePayment()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $postData = Yii::$app->request->post();

        if (empty($postData)) {
            throw new BadRequestHttpException('No coin data received.');
        }

        if (!isset($postData['coin_price'])) {
            throw new BadRequestHttpException('Missing required coin_price.');
        }

        Stripe::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2'); // Replace with actual key

        $coinPrice = $postData['coin_price'];
        $discount = $postData['discount'] ?? 0;

        $totalAmount = $discount > 0
            ? $coinPrice - ($coinPrice * ($discount / 100))
            : $coinPrice;

        $priceInCents = $totalAmount * 100;

        $id = Yii::$app->security->generateRandomString();

        $successUrl = Yii::$app->urlManager->createAbsoluteUrl(['api/payment/payment-success', 'id' => $id]);
        $cancelUrl = Yii::$app->urlManager->createAbsoluteUrl(['api/payment/cancel']);

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => Helper::getCurrency(),
                        'product_data' => ['name' => 'Assignlly Coins'],
                        'unit_amount' => $priceInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);

            return [
                'success' => true,
                'checkout_url' => $checkoutSession->url,
                'session_id' => $checkoutSession->id,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Stripe error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Handle payment cancel (API version).
     */
    public function actionCancel()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        return [
            'success' => false,
            'message' => 'Payment was cancelled by the user.',
        ];
    }

    /**
     * (Optional) Endpoint for payment success.
     */
    public function actionPaymentSuccess($id)
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        return [
            'success' => true,
            'message' => 'Payment completed successfully.',
            'transaction_id' => $id,
        ];
    }
}
