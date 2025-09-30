<?php

/** @var yii\web\View $this */
/** @var string $currentStep */


use app\components\Helper;
use app\models\JobApplications;
use app\models\Profiles;
use app\models\TeacherEducation;
use app\models\TeacherProfessionalExperience;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tutor Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .job-link {
        color: gray;
        text-decoration: none;
    }

    .job-link.active {
        color: blue;
    }
    .wizard-step-item{
        text-decoration: none;
    }
</style>
<?php
// Get current user ID (assuming Yii2 user component)
$userId = Yii::$app->user->id;

// Determine which step to display based on DB completion


// if (Profiles::find()->where(['user_id' => $userId])->exists()) {
//     $currentStep = 'subject-teach';
//     if (TeacherEducation::find()->where(['teacher_id' => $userId])->exists()) {
//         $currentStep = 'professional-experience';
//         if (TeacherProfessionalExperience::find()->where(['user_id' => $userId])->exists()) {
//             $currentStep = 'teaching-details';
//             // You can add more logic for further steps if needed
//         }
//     }
// }

// // Validate step name for security (optional, if you want to allow manual navigation)
// $validSteps = ['teacher-profile', 'subject-teach', 'education-experience', 'professional-experience', 'teaching-details', 'description'];
// if (!in_array($currentStep, $validSteps)) {
//     $currentStep = 'teacher-profile'; // Default to first step if invalid
// }
?>

<?php
// Determine current step from URL path
$currentUrl = Yii::$app->request->pathInfo;
if (strpos($currentUrl, 'profile') !== false) {
    $currentStep = 'teacher-profile';
} elseif (strpos($currentUrl, 'subjects') !== false) {
    $currentStep = 'subject-teach';
} elseif (strpos($currentUrl, 'education') !== false) {
    $currentStep = 'education-experience';
} elseif (strpos($currentUrl, 'professional-experience') !== false) {
    $currentStep = 'professional-experience';
} elseif (strpos($currentUrl, 'teaching-details') !== false) {
    $currentStep = 'teaching-details';
} elseif (strpos($currentUrl, 'description') !== false) {
    $currentStep = 'description';
} else {
    $currentStep = 'teacher-profile';
}
?>



    <div class="wizard-sidebar" style="min-width:220px;">
        <ul class="wizard-steps">
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'teacher-profile') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/profile">Teacher Profile</a>
            </li>
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'subject-teach') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/subjects">Subject</a>
            </li>
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'education-experience') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/education">Education</a>
            </li>
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'professional-experience') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/professional-experience">Professional Experience</a>
            </li>
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'teaching-details') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/teaching-details">Teaching Details</a>
            </li>
            <li>
                <a class="wizard-step-item nav-link2<?php echo ($currentStep == 'description') ? ' active' : ''; ?>" href="<?=Helper::baseUrl("/")?>tutor/description">Description</a>
            </li>
        </ul>
    </div>
