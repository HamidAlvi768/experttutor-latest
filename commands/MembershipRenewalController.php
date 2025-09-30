<?php
namespace app\commands;

use app\models\Membership;
use app\models\Wallets;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use yii\helpers\ArrayHelper;

class MembershipRenewalController extends Controller
{
    /**
     * Renews active memberships by deducting coins and updating expiry_date.
     * Sends email if balance is insufficient.
     * Run monthly via cron (e.g., at 00:00 on the 1st).
     */
    public function actionRenew()
    {
        // Set memory limit and execution time to handle large datasets
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);

        try {
            // Find memberships that are active and due for renewal
            $memberships = Membership::find()
                ->where(['cancelled_from_next_month' => 0])
                ->andWhere(['<=', 'expiry_date', date('Y-m-d H:i:s')])
                ->all();

            if (empty($memberships)) {
                $this->stdout("No memberships due for renewal.\n");
                return ExitCode::OK;
            }

            $locationsToUpdate = [];
            foreach ($memberships as $membership) {
                try {
                    $user = User::findOne($membership->user_id);
                    $wallet = Wallets::find()->where(['user_id' => $membership->user_id])->one();

                    if (!$user || !$wallet) {
                        $this->stderr("User or wallet not found for membership ID {$membership->id}.\n");
                        continue;
                    }

                    // Check if wallet has enough balance
                    if ($wallet->balance >= $membership->premium_coins) {
                        // Deduct coins
                        $wallet->balance -= $membership->premium_coins;
                        if (!$wallet->save()) {
                            $this->stderr("Failed to update wallet for user ID {$membership->user_id}.\n");
                            continue;
                        }

                        // Update expiry_date to end of next month
                        $membership->expiry_date = date('Y-m-d H:i:s', strtotime('last day of next month 23:59:59'));
                        if (!$membership->save()) {
                            $this->stderr("Failed to update membership ID {$membership->id}.\n");
                            continue;
                        }

                        // Track location for rank update
                        $locationsToUpdate[$membership->location] = true;
                        $this->stdout("Renewed membership ID {$membership->id} for user ID {$membership->user_id}, location {$membership->location}.\n");
                    } else {
                        // Send email for insufficient balance
                        $this->sendInsufficientBalanceEmail($user, $membership, $wallet);
                        $this->stdout("Insufficient balance for membership ID {$membership->id}, user ID {$membership->user_id}. Email sent.\n");
                    }
                } catch (\Exception $e) {
                    $this->stderr("Error processing membership ID {$membership->id}: {$e->getMessage()}\n");
                    continue;
                }
            }

            // Update ranks for affected locations
            foreach (array_keys($locationsToUpdate) as $location) {
                $this->updateRanks($location);
                $this->stdout("Updated ranks for location {$location}.\n");
            }

            $this->stdout("Membership renewal completed.\n");
            return ExitCode::OK;
        } catch (\Exception $e) {
            $this->stderr("Critical error in renewal process: {$e->getMessage()}\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    /**
     * Sends an email to the user for insufficient balance.
     * @param User $user
     * @param Membership $membership
     */
    private function sendInsufficientBalanceEmail($user, $membership ,$wallet)
    {
        try {
            Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Your App Name'])
                ->setSubject('Insufficient Balance for Membership Renewal')
                ->setTextBody(
                    "Dear {$user->username},\n\n" .
                    "We attempted to renew your subscription for location {$membership->location} " .
                    "with {$membership->premium_coins} coins, but your wallet balance is insufficient.\n" .
                    "Current balance: {$wallet->balance} coins.\n" .
                    "Please add funds to your wallet to continue your subscription.\n\n" .
                    "Visit " . Yii::$app->urlManager->createAbsoluteUrl(['tutor/buy-membership']) . " to manage your subscription.\n\n" .
                    "Best regards,\nYour App Team"
                )
                ->send();
        } catch (\Exception $e) {
            $this->stderr("Failed to send email to user ID {$user->id}: {$e->getMessage()}\n");
        }
    }

    /**
     * Updates ranks for a given location (copied from actionBuyMembership).
     * @param string $location
     */
    private function updateRanks($location)
    {
        $members = Membership::find()
            ->where(['location' => $location])
            ->andWhere(['cancelled_from_next_month' => 0])
            ->orderBy(['premium_coins' => SORT_DESC])
            ->all();

        if (empty($members)) {
            return;
        }

        $current_rank = 1;
        $ties_count = 1;
        $prev_coins = $members[0]->premium_coins;
        $members[0]->rank = $current_rank;

        for ($i = 1; $i < count($members); $i++) {
            if ($members[$i]->premium_coins == $prev_coins) {
                $members[$i]->rank = $current_rank;
                $ties_count++;
            } else {
                $current_rank += $ties_count;
                $members[$i]->rank = $current_rank;
                $ties_count = 1;
                $prev_coins = $members[$i]->premium_coins;
            }
        }

        foreach ($members as $mem) {
            $mem->save(false);
        }
    }
}