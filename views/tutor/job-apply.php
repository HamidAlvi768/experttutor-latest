<?php
use app\components\Helper;
use app\models\JobApplications;
use yii\helpers\Html;

$this->title = 'Tutor Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$actionId = Yii::$app->controller->action->id;

// ---- Config ----
$baseApplyCoin      = !empty($ApplyCoin) ? $ApplyCoin : 0;
$maxMembershipCoin  = $member_applycoins ;

$jobPostedTime      = strtotime($post->created_at);
$currentTime        = time();
$timeSincePosted    = $currentTime - $jobPostedTime;

$minutesSincePosted = (int) floor($timeSincePosted / 60.0);

$user               = Yii::$app->user->identity;
$user_wallet        = $user->wallet;
$isMember           = !empty($isMember);
$membershipCoins    = $isMember ? (int) ($isMember ? $totalActiveCoins : 0) : 0;

$isEarly            = $minutesSincePosted < 90;
$dynamic_cost       = $isEarly ? (int) round($maxMembershipCoin * (1.0 - $minutesSincePosted / 90.0)) : 0;
$apply_coins        = $isEarly ? (int) max($baseApplyCoin, max(0, $dynamic_cost - $membershipCoins)) : (int) $baseApplyCoin;
$canApply           = true;

$remainingTime      = max(0, 90 * 60 - $timeSincePosted);
$timerDisplay       = $remainingTime > 0 ? gmdate("H:i:s", $remainingTime) : '';

$user_t_future = $membershipCoins < $maxMembershipCoin ? (int) round(90.0 * (1.0 - $membershipCoins / (float) $maxMembershipCoin)) : 0;
$user_remaining_minutes = max(0, $user_t_future - $minutesSincePosted);
$user_remainingTime = $user_remaining_minutes * 60;
$user_timerDisplay = $user_remainingTime > 0 ? gmdate("H:i:s", $user_remainingTime) : '';

$messageApplied = $applied->message ?? false;
$callApplied = $applied->call ?? false;
$bothApplied = $messageApplied && $callApplied;

$showTimer          = $isEarly && ($user_remaining_minutes > 0) && !$bothApplied;

$user_slug= Helper::getuserslugfromid($post->getPostedBy()->one()->id);
$chatUrl = Helper::baseUrl("peoples/chat?other={$user_slug}&post={$post->id}");
$encodedChatUrl = urlencode($chatUrl);
?>

<style>
    .tutor-name {
        font-size: 2.5rem !important;
        width: max-content;
        text-align: center;
    }

    .tutor-info {
        display: flex;
        justify-content: center;
    }

    .tutor-profile-section {
        margin-top: 1.5rem;
    }

    .job-detail-container .col-lg-4 {
        background: #F7F7F7;
        padding: 1rem 2rem;
        border-radius: 10px;
    }

    @media (max-width: 992px) {
        .job-details-grid {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)) !important;
        }

        .expertTutor_jobDetail_layout {
            grid-template-columns: 1fr;
        }

        .expertTutor_jobDetail_meta {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }

    .expertTutor_jobDetail_meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
    }

    .job-detail-description {
        margin: 16px 0;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9e8e8;
    }

    .job-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.4rem;
        margin: 2rem 0;
        padding: 0;
        background: transparent;
        border-radius: 0;
        border: none;
    }

    .col-lg-5 .job-detail-section {
        margin-top: 1rem;
    }

    .job-detail-section {
        margin-bottom: 0.5rem;
        padding: 0.65rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        border-left: 4px solid var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .job-detail-section h4 {
        color: #495057;
        font-size: 0.65rem;
        font-weight: 600;
        margin-bottom: 0rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .job-detail-section .value {
        color: #565f68;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .job-detail-section .value.highlight {
        color: #09B31A;
        font-weight: 600;
    }

    .job-detail-section .value.warning {
        color: #dc3545;
    }

    .job-detail-section .value.info {
        color: #0d6efd;
    }

    .timer-container {
        background: linear-gradient(135deg, #09B31A, #07a016);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(9, 179, 26, 0.3);
        position: relative;
        /* overflow: hidden; */
    }

    .timer-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .timer-label {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .timer-display {
        font-size: 2.5rem;
        font-weight: bold;
        font-family: 'Courier New', monospace;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        letter-spacing: 2px;
    }

    .membership-info {
        background: #f8f9fa;
        color: #09B31A;
        border: 1px solid #e9ecef;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
    }

    .membership-coins {
        color: #09B31A;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .purchase-prompt {
        color: #856404;
        font-weight: 500;
    }

    .btn-membership {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background-color: #09B31A;
        color: white;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .btn-membership:hover {
        background-color: #07a016;
    }

    .membership-expired-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        text-align: center;
    }
</style>

<!-- Job Application Section -->
<section class="job-detail-section mt-4">
    <div class="container">
        <div class="job-detail-container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="job-detail">
                        <h1 class="job-detail-title"><?= Html::encode($post->title) ?></h1>
                        <!-- Job Details Grid -->
                        <div class="job-details-grid">
                            <div class="job-detail-section">
                                <h4>Pay Schedule</h4>
                                <div class="value highlight"><?= !empty($post->charge_type) ? Html::encode($post->charge_type) : '-' ?></div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Time Ago</h4>
                                <div class="value"><?= Yii::$app->formatter->asRelativeTime($post->created_at) ?></div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Level</h4>
                                <div class="value"><?= !empty($post->level) ? Html::encode(ucfirst($post->level)) : '-' ?></div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Posted By</h4>
                                <div class="value">
                                    <?php $postedBy = $post->getPostedBy()->one(); ?>
                                    <?= $postedBy ? Html::encode(ucfirst($postedBy->username)) : '-' ?>
                                </div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Role</h4>
                                <div class="value">Student</div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Subject</h4>
                                <div class="value">
                                    <?= ($post->subject != 'other') ? Html::encode(ucfirst($post->subject)) : Html::encode(ucfirst($post->other_subject ?: "-")) ?>
                                </div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Tutor From</h4>
                                <div class="value"><?= !empty($post->tutor_from) ? Html::encode(ucfirst($post->tutor_from)) : '-' ?></div>
                            </div>
                            <div class="job-detail-section">
                                <h4>Meeting Option</h4>
                                <div class="value"><?= !empty($post->meeting_option) ? Html::encode(ucfirst($post->meeting_option)) : '-' ?></div>
                            </div>
                            <?php
                            $totalApplied = JobApplications::find()->where(['job_id' => $post->id])->count();
                            ?>
                            <div class="job-detail-section">
                                <h4>Total Tutor Applied</h4>
                                <div class="value"><?= !empty($totalApplied) ? Html::encode(ucfirst($totalApplied)) : '-' ?></div>
                            </div>
                            <?php if ($post->document): ?>
                                <div class="job-detail-section">
                                    <h4>Requirement File</h4>
                                    <div class="value">
                                        <a href="<?= Helper::baseUrl($post->document) ?>" target="_blank">View Document</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="job-detail-section">
                                <h4>Gender Preference</h4>
                                <div class="value"><?= !empty($post->gender) ? Html::encode($post->gender) : 'None' ?></div>
                            </div>
                            <?php if ($post->want == 'online'): ?>
                                <div class="job-detail-section">
                                    <h4>Available Online</h4>
                                    <div class="value highlight">Yes</div>
                                </div>
                            <?php endif; ?>
                            <?php if ($post->want == 'home'): ?>
                                <div class="job-detail-section">
                                    <h4>Available for Home Tutoring</h4>
                                    <div class="value highlight">Yes</div>
                                </div>
                            <?php endif; ?>
                            <?php if ($post->want == 'assigment'): ?>
                                <div class="job-detail-section">
                                    <h4>Assignment Work</h4>
                                    <div class="value highlight">Yes</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="job-detail-description">
                            <?php
                            $desc = $post->details;
                            $desc = str_replace(
                                ['Key Responsibilities:', 'Ideal Candidate:'],
                                ['<strong>Key Responsibilities:</strong>', '<strong>Ideal Candidate:</strong>'],
                                $desc
                            );
                            $desc = nl2br($desc);
                            $desc = preg_replace('/- (.+?)(?=<br|$)/m', '• $1', $desc);
                            echo $desc;
                            ?>
                        </div>
                        <div class="expertTutor_jobDetail_meta">
                            <div class="expertTutor_jobDetail_price">
                                <span class="expertTutor_jobDetail_currency"><?= Helper::getCurrency() ?></span>
                                <?= Html::encode($post->budget) ?>
                            </div>
                            <div class="expertTutor_jobDetail_location">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1983_3041)">
                                        <path d="M21.5801 10.2247C21.5801 17.2247 12.5801 23.2247 12.5801 23.2247C12.5801 23.2247 3.58008 17.2247 3.58008 10.2247C3.58008 7.83775 4.52829 5.54857 6.21612 3.86074C7.90394 2.17291 10.1931 1.2247 12.5801 1.2247C14.967 1.2247 17.2562 2.17291 18.944 3.86074C20.6319 5.54857 21.5801 7.83775 21.5801 10.2247Z" stroke="#09B31A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12.5801 13.2247C14.2369 13.2247 15.5801 11.8816 15.5801 10.2247C15.5801 8.56785 14.2369 7.2247 12.5801 7.2247C10.9232 7.2247 9.58008 8.56785 9.58008 10.2247C9.58008 11.8816 10.9232 13.2247 12.5801 13.2247Z" stroke="#09B31A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1983_3041">
                                            <rect width="24" height="24" fill="white" transform="translate(0.580078 0.224701)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <?= Html::encode($post->location) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    
                    <?php if ($showTimer): ?>
                        <div class="timer-container">
                            <div class="timer-label">Time Remaining To Apply Normal  <br>(  <?= $baseApplyCoin > 0 ? $baseApplyCoin:0  ?>  Coins)</div>
                            <div class="timer-display" id="timer"><?= $user_timerDisplay ?></div>
                             <?php if ($isMember): ?>
                        <div class="membership-info">
                            <div><strong>Your Membership Coins:</strong> <span class="membership-coins"><?= $membershipCoins ?></span></div>
                             <div><strong>Job Membership Coin:</strong> <span class="membership-coins"><?= $member_applycoins ?></span></div>
                        </div>
                    <?php else: ?>
                        <div class="membership-info">
                            <div class="purchase-prompt">No active membership. Purchase to unlock early apply benefits and save coins!</div>
                            <a href="<?= Helper::baseUrl('tutor/buy-membership') ?>" class="btn-membership">Purchase Membership</a>
                        </div>
                    <?php endif; ?>
                        </div>
                    <?php endif; ?>


                    <div class="job-actions">
                        <a href="javascript:void(0);" id="message-btn" class="btn-message">
                            Message
                            <div class="coin-info">
                                <span id="message-status" class="apply-status"><?= $messageApplied ? 'Applied (Free)' : ($apply_coins > 0 ? 'Coin Need ' . $apply_coins : 'Free') ?></span>
                                <img src="<?= Helper::baseUrl() ?>/custom/images/icons/coin.png" alt="Coin" class="coin-icon">
                            </div>
                        </a>
                        <?php if ($post->call_option != 0): ?>
                            <a href="javascript:void(0);" id="call-btn" class="btn-call">
                                View Number
                                <div class="coin-info">
                                    <span id="call-status" class="apply-status"><?= $callApplied ? 'Applied (Free)' : ($apply_coins > 0 ? 'Coin Need ' . $apply_coins : 'Free') ?></span>
                                    <img src="<?= Helper::baseUrl() ?>/custom/images/icons/coin.png" alt="Coin" class="coin-icon">
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript for Timer and Live Coin Cost Update -->
<script>
    let messageApplied = <?= json_encode($messageApplied) ?>;
    let callApplied = <?= json_encode($callApplied) ?>;
    let baseApplyCoin = <?= $baseApplyCoin ?>;
    let membershipCoins = <?= $membershipCoins ?>;
    let maxMembershipCoin = <?= $maxMembershipCoin ?>;
    let jobPostedTime = <?= $jobPostedTime ?>;
    let baseApplyUrl = '<?= Helper::baseUrl("tutor/apply-now") ?>';
    let postId = <?= $post->id ?>;
    let chatUrl = '<?= $chatUrl ?>';
    let messageRedirectUrl = '<?= $encodedChatUrl ?>';
    let user_t_future_minutes = <?= $user_t_future ?>;

    function updateCosts() {
        let minutesSincePosted = Math.floor((Date.now() / 1000 - jobPostedTime) / 60);
        let dynamic = minutesSincePosted < 90 ? Math.round(maxMembershipCoin * (1 - minutesSincePosted / 90)) : 0;
        let additional = minutesSincePosted < 90 ? Math.max(baseApplyCoin, Math.max(0, dynamic - membershipCoins)) : baseApplyCoin;

        let costText = additional > 0 ? `Coin Need ${additional}` : 'Free';

        if (document.getElementById('message-status') && !messageApplied) {
            document.getElementById('message-status').innerHTML = costText;
        }
        if (document.getElementById('call-status') && !callApplied) {
            document.getElementById('call-status').innerHTML = costText;
        }

        let membershipCoinDisplays = document.getElementsByClassName('membershipCoinCost');
        for (let disp of membershipCoinDisplays) {
            disp.textContent = dynamic;
        }

        // Dynamically hide timer if no extra cost
        let timerDiv = document.querySelector('.timer-container');
        if (timerDiv && minutesSincePosted >= user_t_future_minutes) {
            timerDiv.style.display = 'none';
        }
    }

    function startTimer(duration, display) {
        let timer = duration;
        let interval = setInterval(function () {
            let hours = Math.floor(timer / 3600);
            let minutes = Math.floor((timer % 3600) / 60);
            let seconds = timer % 60;
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            display.textContent = hours + ':' + minutes + ':' + seconds;

            updateCosts();

            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = '00:00:00';
                updateCosts();
                setTimeout(() => { window.location.reload(); }, 1000);
            }
        }, 1000);
    }

    window.addEventListener('load', function () {
        updateCosts();

        <?php if ($showTimer): ?>
            let timerDisplay = document.getElementById('timer');
            if (timerDisplay) {
                startTimer(<?= $user_remainingTime ?>, timerDisplay);
            }
        <?php endif; ?>

        let messageBtn = document.getElementById('message-btn');
        if (messageBtn) {
            messageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (messageApplied) {
                    window.location.href = chatUrl;
                    return;
                }
                let minutesSincePosted = Math.floor((Date.now() / 1000 - jobPostedTime) / 60);
                let dynamic = minutesSincePosted < 90 ? Math.round(maxMembershipCoin * (1 - minutesSincePosted / 90)) : 0;
                let additional = minutesSincePosted < 90 ? Math.max(baseApplyCoin, Math.max(0, dynamic - membershipCoins)) : baseApplyCoin;
                let confirmMsg = `Your ${additional} coins will be deducted for message service. Continue?`;
                Swal.fire({
                    title: 'Confirm Action',
                    text: confirmMsg,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = `${baseApplyUrl}?id=${postId}&coins=${additional}&url=${messageRedirectUrl}`;
                        window.location.href = url;
                    }
                });
            });
        }

        let callBtn = document.getElementById('call-btn');
        if (callBtn) {
            callBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (callApplied) {
                    let url = `${baseApplyUrl}?id=${postId}&coins=0&url=call`;
                    window.location.href = url;
                    return;
                }
                let minutesSincePosted = Math.floor((Date.now() / 1000 - jobPostedTime) / 60);
                let dynamic = minutesSincePosted < 90 ? Math.round(maxMembershipCoin * (1 - minutesSincePosted / 90)) : 0;
                let additional = minutesSincePosted < 90 ? Math.max(baseApplyCoin, Math.max(0, dynamic - membershipCoins)) : baseApplyCoin;
                let confirmMsg = `Your ${additional} coins will be deducted for call service. Continue?`;
                Swal.fire({
                    title: 'Confirm Action',
                    text: confirmMsg,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = `${baseApplyUrl}?id=${postId}&coins=${additional}&url=call`;
                        window.location.href = url;
                    }
                });
            });
        }
    });
</script>