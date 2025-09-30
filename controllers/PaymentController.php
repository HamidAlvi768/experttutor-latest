<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Bookings;
use Yii;
use yii\web\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function actionStripePayment()
    {
        // Set your Stripe secret key
        Stripe::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2'); // Replace with your actual Stripe test secret key

        // Retrieve form data or session data (if applicable)
        $postData = Yii::$app->session->get('coin');


                                        
        if (!empty($postData['discount']) && $postData['discount'] > 0)
        {
            $toalamount = $postData['coin_price'] - ($postData['coin_price'] * ($postData['discount'] / 100));
        }else{
                $toalamount = $postData['coin_price'];
        }         


        if (!$postData) {
            throw new \yii\web\BadRequestHttpException('No coins data found in session.');
        }
        
        $priceInCents = $toalamount * 100; // Convert to cents
        $id=Yii::$app->security->generateRandomString();
        Yii::$app->session->set('id',$id);

        // Create a Stripe Checkout session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' =>  Helper::getCurrency() ,
                    'product_data' => [
                        'name' => 'Assignlly Coins',
                    ],
                    'unit_amount' => $priceInCents, // Amount in cents (10.00 USD)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => Yii::$app->urlManager->createAbsoluteUrl(['tutor/payment-success','id'=>$id]),
            'cancel_url' => Yii::$app->urlManager->createAbsoluteUrl(['payment/cancel']),
        ]);

        // Redirect user to Stripe Checkout
        return $this->redirect($checkoutSession->url);
    }
    public function actionCancel()
    {
        echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Payment Cancelled</title>
    </head>
    <body>
        <h1>Payment Cancelled</h1>
        <p>Your payment has been cancelled.</p>
        <a href="' . Helper::baseUrl("/") . '">Return to Home</a>
    </body>
    </html>';

        Yii::$app->end();
    }
}
