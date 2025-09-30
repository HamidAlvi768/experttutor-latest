<?php

use app\components\Helper;
use app\controllers\api\TutorController;
use app\models\ApplyCoin;
use app\models\JobApplications;
use app\models\Reviews;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<style>
    .main-container {
        margin-top: 2rem;
    }
    
.tutor-name {
    font-size: clamp(1.2rem, 4vw, 2rem) !important; /* 19.2px → 32px */
    width: max-content;
    text-align: center;
}

.tutor-info {
    display: flex;
    /* justify-content: center; */
}

.tutor-profile-section {
    margin-top: 1.5rem;
}

 .job-card {
     position: relative;
     margin-bottom: 1rem;
     border: 1px solid #eee;
     border-radius: 10px;
     box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
     padding: 1.5rem;
     background: #fff;
     padding-bottom: 1rem;
    }
    
    .save-heart.saved {
        color: #28a745;
    }
    
    .save-heart.unsaved {
        color: #bbb;
    }
    
    .job-content {
        position: relative;
    }
    
    .job-footer {
        position: absolute;
        right: 1.5rem;
        bottom: 1.5rem;
    }
    
    .btn-apply {
        min-width: 110px;
        text-align: center;
    }
    @media (max-width: 992px) {
        .btn-apply {
            min-width: 60px;
        }
    }
    
    .expertTutor_dashboard_status {
    background: #F3F4F6;
    color: #6B7280;
    padding: 12px 25px !important;
    border-radius: 6px;
    font-size: clamp(0.6rem, 2vw, 0.75rem); /* 9.6px → 12px */
    font-weight: 500;
    margin-right: 12px;
    display: inline-block;
}
    
    .disabled-link {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .job-description {
    font-size: clamp(0.75rem, 2.5vw, 0.8rem) !important; /* 12px → 16px */
}
    
    .job-title {
    font-size: clamp(0.9rem, 3.5vw, 1.1rem) !important; /* 14.4px → 17.6px */
    color: var(--primary-color);
}
    
    .jobs_subject {
    font-size: clamp(0.6rem, 2vw, 0.7rem) !important; /* 9.6px → 12.8px */
}
    
    .list-inline-icons {
        display: flex !important;
        justify-content: center;
        align-items: center;
        margin: 0px;
        padding: 0px;
        list-style: none;
        gap: 10px;
    }
    
    .list-inline {
    gap: clamp(0.4rem, 3vw, 2rem);
}
    
    .job-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        flex-wrap: wrap;
    }
    
    .job-header, 
    .job-header-content {
        display: flex;
        justify-content: center;
        /* align-items: center; */
    }
    
     .job-actions-container {
     align-items: center;
     display: flex;
     justify-content: space-between;
     padding: 24px;
 }
 
 /* Empty rulesets for classes without CSS */
 .amount-label {
 }
 
 .amount-value {
 }
 
 .amount-currency {
 }
 
 .job-amount {
 }
 
 @media (min-width: 769px) {
    .job-tags-section {
        margin-bottom: 0rem;
    }
 }
 
 .verification-badge {
    font-size: clamp(0.6rem, 2vw, 0.8rem);
 }
 
 .rate-container {
 }
 
 .rate-value {
 }
 
 .footer-icon {
    font-size: clamp(0.7rem, 2.5vw, 0.8rem);
}

.footer-text {
    font-size: clamp(0.7rem, 2.5vw, 0.8rem);
}

.review-section {
}

.tooltips {
    font-size: clamp(0.7rem, 2.5vw, 0.9rem);
}
    @media (max-width: 992px) {
        .job-card {
            padding: 1rem;
            margin-bottom: 1.5rem;
     }
     .job-actions-container {
         padding: 12px;
     }
 }
 
 
 @media (max-width: 480px) {
     .job-card {
         padding: 0.5rem;
         margin-bottom: 0.75rem;
     }
 }


@media (max-width: 768px) {
    .job-card {
         padding: 0rem;
         margin-bottom: 1rem;
     }
    .job-card-footer {
        flex-direction: column;
        align-items: stretch;
    }
    .job-header {
        flex-direction: row;
        align-items: flex-start;
        justify-content: flex-start;
        margin-bottom: 0.5rem;
    }
    .job-header-content {
        flex-direction: row;
        font-size: clamp(0.75rem, 3vw, 1rem);
    }
}

.job-card.clickable {
    cursor: pointer;
}

.job-card.clickable:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

<?php 
         $totalApplied = JobApplications::find()->where(['job_id' => $model->id])->count();

$location = $model->location; // e.g. "Islamabad, Pakistan"
$apply_coin = new ApplyCoin();
$result = $apply_coin->getContinentFromLocation($location);

// Build query
$query = ApplyCoin::find();

if (!empty($result['continent'])) {
    $query->where(['like', 'country', $result['continent']]);
} 

// Always include default as fallback
$query->orWhere(['country' => 'default']);

$regions = $query->orderBy(['country' => SORT_DESC])->one();

// Safe fallback if still nothing found
$coinValue = $regions ? $regions->coin_value : 20; 

?>

<?php
    $url = Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]);
    $isClickable = false;
    $applied = JobApplications::find()->where(['job_id' => $model->id, 'applicant_id' => Yii::$app->user->identity->id])->one();
    $requestStatus = Yii::$app->db->createCommand("
        SELECT application_status FROM job_applications 
        WHERE job_id = :post_id AND applicant_id = :tutor_id
    ", [':post_id' => $model->id, ':tutor_id' => Yii::$app->user->identity->id])->queryScalar();

    if ($applied && $model->post_status != 'complete') {
        if ($requestStatus === 'accepted' || $requestStatus !== 'rejected') {
            $isClickable = true;
        }
    } elseif ($model->post_status == 'active' && $model->posted_by != Yii::$app->user->identity->id) {
        $isClickable = true;
    }
?>

<div class="job-card <?= $isClickable ? 'clickable' : '' ?>"  <?= $isClickable ? 'data-url="' . $url . '"' : '' ?>>

 <div class="job-content">

               <div class="job-header">
          <h2 class="job-title"><?= Html::encode($model->title) ?> <?php if($requestStatus == 'rejected'){?><span class="" style="color:red;font-size: small;">(Application Rejected)</span><?php }?></h2>
          <div class="job-header-content gap-2">
            <?php /*?>
             <div class="job-amount">
                 <span class="amount-label" style="margin-right: 0.4rem;">Amount: </span>
                 <span class="amount-value"><?= Html::encode($model->budget) ?></span>
                 <span class="amount-currency"><?= Helper::getCurrency() ?></span>
             </div>
             <?php */?>
          <span class="save-heart <?= $isSaved ? 'saved' : 'unsaved' ?>" title="Save Job">
              <?= $isSaved
                     ? '<svg width="28" height="28" viewBox="0 0 24 24" fill="#28a745" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'
                     : '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'
                 ?>
          </span>
          </div>
      </div>

     <div class="job-tags-section d-flex flex-wrap gap-2">


         <?php if (
                (!empty($model->subject) && $model->subject != 'other')
                || (!empty($model->other_subject) && $model->subject == 'other')
            ): ?>
             <span class="jobs_subject btn btn-outline-secondary mb-2" style="width: fit-content;">
                 <?= ($model->subject != 'other')
                        ? Html::encode(ucfirst($model->subject))
                        : Html::encode(ucfirst($model->other_subject)) ?>
             </span>
         <?php endif; ?>


         <ul class="list-inline-icons">
             <!-- Phone Verified -->
             <?php $postedBy = $model->getPostedBy()->one(); ?>
             <?php
                $hasPhoneVerified = false;

                if (!empty($model->postedBy->userVerifications)) {
                    foreach ($model->postedBy->userVerifications as $verification) {
                        if ($verification->phone_verified == 1) {
                            $hasPhoneVerified = true;
                            break;
                        }
                    }
                }


                ?>
                           <li class="tooltips no-padding" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= (!empty($hasPhoneVerified) && $hasPhoneVerified) ? 'Phone Verified' : 'Phone Not Verified' ?>">
                  <span class="verification-badge h5">
                      <i class="fas fa-mobile-alt" style="min-width:13.63px;display: inline-block; color:<?= (!empty($hasPhoneVerified) && $hasPhoneVerified) ? '#212529' : '#bbb' ?>;"></i>
                  </span>
              </li>
                           <!-- Online Option -->
              <li class="tooltips margin-right-10- no-padding" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= ($model->want == 'online') ? 'Online Tutoring Available' : 'Online Tutoring Not Available' ?>">
                  <span class="verification-badge h5">
                      <i class="fas fa-wifi" style="min-width:26.75px;display: inline-block; color:<?= ($model->want == 'online') ? '#212529' : '#bbb' ?>;"></i>
                  </span>
              </li>

                           <!-- Home Option -->
              <li class="tooltips margin-right-10- no-padding" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= ($model->want == 'home') ? 'Home Tutoring Available' : 'Home Tutoring Not Available' ?>">
                  <span class="verification-badge h5">
                      <i class="fa fa-home" style="min-width:24.13px;display: inline-block; color:<?= ($model->want == 'home') ? '#212529' : '#bbb' ?>;"></i>
                  </span>
              </li>

                           <!-- Assignment Option -->
              <li class="tooltips margin-right-10- no-padding" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= ($model->want == 'assigment') ? 'Assignment Help Available' : 'Assignment Help Not Available' ?>">
                  <span class="verification-badge h5">
                      <i class="fa fa-file-alt" style="min-width:24.13px;display: inline-block; color:<?= ($model->want == 'assigment') ? '#212529' : '#bbb' ?>;"></i>
                  </span>
              </li>

                              <!-- For mobile: show verified badge if posted user is verified -->
                 <?php if (!empty($postedBy->is_verified)): ?>
                     <li class="tooltips no-padding" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Verified User">
                         <span class="verification-badge h5">
                             <i class="fas fa-badge-check" style="min-width:20px;display: inline-block;color:#28a745;"></i>
                         </span>
                     </li>
                 <?php endif; ?>
         </ul>


     </div>


     <p class="job-description">
         <?= Html::encode(mb_substr($model->details, 0, 150)) . (mb_strlen($model->details) > 150 ? '...' : '') ?>
     </p>

     <div class="job-card-footer">
     <ul class="list-inline down-ul no-padding-left-li mb-0 d-flex flex-wrap">


      <!-- Rate -->
         <li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= !empty($model->usd_equivalent) ? Html::encode($model->usd_equivalent) . ' USD (' . Helper::getCurrency() . ' ' . Html::encode($model->budget) . ')' : Helper::getCurrency() . ' ' . Html::encode($model->budget) . ' Per ' . Html::encode($model->charge_type) ?> ">
             <span class="rate-container">
                 <span class="footer-icon h5 margin-right-2 currencyDisplay" content="<?= !empty($model->usd_equivalent) ? 'USD' : Helper::getCurrency() ?>">
                     <?= !empty($model->usd_equivalent) ? '$' : Helper::getCurrency() ?>
                 </span>
                 <span class="rate-value footer-text">
                     <?= !empty($model->usd_equivalent) ? Html::encode($model->usd_equivalent) . '/' . Html::encode($model->charge_type) : Html::encode($model->budget) . '/' . Html::encode($model->charge_type) ?>
                 </span>
             </span>
         </li>
         <!-- Posted Time -->
         <li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Posted: <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d-M-Y H:i') ?>">
             <span class="footer-icon h5"><i class="far fa-calendar-alt" style="min-width:18px;"></i></span>
             <span class="footer-text"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
         </li>

        <!-- Coins to apply -->
               <li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Coins Need To Apply: <?= $coinValue ?>">
                     <span class="footer-icon h5">
                         <i class="fas fa-coins" style="min-width:16px;"></i>
                     </span>
                     <span class="footer-text"><?= $coinValue; ?></span>
                 </li>
         <!-- Location -->
         <?php /* if ($model->location): ?>
             <li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Location: <?= Html::encode($model->location) ?>">
                 <span class="h5">
                     <i class="fas fa-map-marker-alt" style="min-width:16px;"></i>
                 </span>
                 <span><?= Html::encode($model->location) ?></span>
             </li>
         <?php endif;   */?>

        

         <?php $postedBy = $model->getPostedBy()->one(); ?>
         <?php /* if ($postedBy->username): ?>

             <li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Posted By Student: <?= $postedBy ? Html::encode(ucfirst($postedBy->username)) . ($postedBy->id == Yii::$app->user->id ? ' (You)' : '') : '-' ?>">
                 <span class="footer-icon h5">
                     <i class="fas fa-user" style="min-width:16px;"></i>
                 </span>
                 <span class="footer-text">
                     <?= $postedBy ? Html::encode(ucfirst($postedBy->username)) . ($postedBy->id == Yii::$app->user->id ? ' (You)' : '') : '-' ?></span>
             </li>
         <?php endif;  */ ?>

<!-- Applied Count -->
<li class="tooltips margin-right-10" data-bs-toggle="tooltip" data-bs-placement="bottom" 
    title="Total Applied: <?= $totalApplied ?>">
    <span class="footer-icon h5"><i class="fa fa-file-pen" style="min-width:16px;"></i></span>
    <span class="footer-text"><?= $totalApplied ?></span>
</li>



     </ul>


           <div class="job-actions-container">
         <span><?php //Yii::$app->formatter->asRelativeTime($model->created_at) 
                ?></span>


         <?php if (!($applied && $model->post_status != 'complete')): ?>
             <?php if ($model->post_status != 'active'): ?>
                 <?php if ($requestStatus === 'accepted'): ?>
                     <div class="review-section">

                         <?php
                            $reviewd = Reviews::find()
                                ->where(['job_id' => $model->id])
                                ->andWhere(['user_id' => Yii::$app->user->identity->id])
                                ->one();
                            ?>
                         <?php
                            $twoDaysPassed = (time() - strtotime($model->updated_at)) > (2 * 24 * 60 * 60);
                            ?>

                         <span class="expertTutor_dashboard_status">
                             <?php if (!$reviewd && !$twoDaysPassed): ?>
                                 <a href="#"
                                     data-bs-toggle="modal"
                                     data-bs-target="#reviewModal"
                                     data-job-id="<?= $model->id ?>"
                                     data-role="tutor">
                                     Review
                                 </a>
                             <?php else: ?>
                                 <a href="#"
                                     data-bs-toggle="modal"
                                     data-bs-target="#reviewModaldisabled"
                                     data-job-id="<?= $model->id ?>"
                                     data-role="tutor">
                                     Reviewed
                                 </a>
                             <?php endif; ?>
                         </span>

                     </div>
                 <?php endif; ?>
             <?php endif; ?>
         <?php endif; ?>

     </div>
     </div>
 </div>
</div>


<script>
 // Initialize Bootstrap 5 tooltips
 document.addEventListener('DOMContentLoaded', function() {
     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
     tooltipTriggerList.forEach(function(tooltipTriggerEl) {
         new bootstrap.Tooltip(tooltipTriggerEl);
     });
 });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.job-card.clickable');
    cards.forEach(card => {
        card.addEventListener('click', e => {
            if (!e.target.closest('.save-heart, [data-bs-toggle="modal"]')) {
                window.location.href = card.dataset.url;
            }
        });
    });
});
</script>