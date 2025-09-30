<?php
namespace app\controllers;

use app\components\Mail;
use app\models\Membership;
use app\models\Wallets;
use app\models\User;
use app\models\WalletTransactions;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CronController extends Controller
{
    /**
     * @inheritdoc
     */

    /**
     * Renews active memberships via web request.
     * Accessible at /tutor/renew-subscriptions (POST only).
     * Returns JSON response.
     * @return array
     */
    public function actionRenewSubscriptions()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Set memory and execution time limits (adjust as needed for web context)
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);

        try {
            // Find memberships that are active and due for renewal
            $memberships = Membership::find()
                ->where(['auto_renew' => 1])
                ->andWhere(['<=', 'memb_expiry', date('Y-m-d H:i:s')])
                ->andWhere(['cancelled_from_next_month' => 0])
                ->all();

            if (empty($memberships)) {
                return ['success' => true, 'message' => 'No memberships due for renewal.'];
            }

            $renewedCount = 0;
            $insufficientCount = 0;

            foreach ($memberships as $membership) {
                try {
                    $user = User::findOne($membership->user_id);
                    $wallet = Wallets::findOne(['user_id' => $membership->user_id]);

                    if (!$user || !$wallet) {
                        Yii::error("User or wallet not found for membership ID {$membership->id}");
                        continue;
                    }

                    $price = $membership->premium_coins; // Deduct previous premium_coins amount

                    if ($wallet->balance >= $price) {
                        // Deduct from balance
                        $wallet->balance -= $price;
                        if (!$wallet->save()) {
                            Yii::error("Failed to update wallet for user ID {$membership->user_id}");
                            continue;
                        }

                        // Update memb_expiry to next 30 days (keep coins as is)
                        $membership->memb_expiry = date("Y-m-d H:i:s", strtotime("+1 month"));
                        if (!$membership->save()) {
                            Yii::error("Failed to update membership ID {$membership->id}");
                            continue;
                        }

                        // Update user membership status if no active left
                        if (!Membership::hasActiveMembership($membership->user_id)) {
                            $user->membership = 'no';
                            $user->save();
                        }

                        $transaction = new WalletTransactions();
                        $transaction->wallet_id = $wallet->id;
                        $transaction->transaction_type = "debit";
                        $transaction->amount = $price;
                        $transaction->description = "{$price} membership coins deducted for auto-renewal.";
                        $transaction->status = "completed";
                        $transaction->save();

                        $renewedCount++;
                        Yii::info("Renewed membership ID {$membership->id} for user ID {$membership->user_id}");
                    } else {
                        $this->sendInsufficientBalanceEmail($user, $membership, $wallet);
                        $insufficientCount++;
                        Yii::warning("Insufficient balance for membership ID {$membership->id}, user ID {$membership->user_id}");
                    }
                } catch (\Exception $e) {
                    Yii::error("Error processing membership ID {$membership->id}: {$e->getMessage()}");
                    continue;
                }
            }

            return [
                'success' => true,
                'message' => "Renewal completed. Renewed: {$renewedCount}, Insufficient balance: {$insufficientCount}.",
            ];
        } catch (\Exception $e) {
            Yii::error("Critical error in renewal process: {$e->getMessage()}");
            return ['success' => false, 'message' => 'An error occurred during renewal: ' . $e->getMessage()];
        }
    }

    /**
     * Sends an email to the user for insufficient balance.
     * @param User $user
     * @param Membership $membership
     * @param Wallets $wallet
     */
    private function sendInsufficientBalanceEmail($user, $membership, $wallet)
    {
        try {
            Mail::send(
                $user->email,
                'Insufficient Coins for Premium Membership Renewal',
                'mail/balance-cron-email.php',
                [
                    'user' => $user,
                    'wallet' => $wallet,
                    'membership' => $membership, // Pass membership for template if needed
                ]
            );
        } catch (\Exception $e) {
            Yii::error("Failed to send email to user ID {$user->id}: {$e->getMessage()}");
        }
    }
}