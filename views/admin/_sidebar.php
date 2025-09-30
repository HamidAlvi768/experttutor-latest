<?php

use yii\helpers\Html;

?>
<style>
    .nav-link {
        color: var(--secondary);
    }

    .nav-link.active {
        color: var(--primary);
    }
</style>

<?php 
$actionId = Yii::$app->controller->action->id;
?>

<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar">
    <ul class="nav">
        <li class="nav-item">
            <?= Html::a('Profile', ['/tutor/profile'], ['class' => 'nav-link '.($actionId=="teacher-profile"?"active":"")]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Teacher Subjects', ['/tutor/subjects'], ['class' => 'nav-link'.($actionId=="teacher-subjects"?"active":"")]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Teacher Education', ['/tutor/education'], ['class' => 'nav-link'.($actionId=="teacher-education"?"active":"")]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Professional Experiece', ['/tutor/professional-experience'], ['class' => 'nav-link'.($actionId=="professional-experience"?"active":"")]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Teachin Details', ['/tutor/teaching-details'], ['class' => 'nav-link'.($actionId=="teaching-details"?"active":"")]) ?>
        </li>
        <li class="nav-item">
            <?= Html::a('Description', ['/tutor/description'], ['class' => 'nav-link'.($actionId=="teacher-description"?"active":"")]) ?>
        </li>
    </ul>
</div>