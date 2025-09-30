<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\ApplyCoin */

?>

<div class="page-wrapper">
    <div class="content">
        <div class="coins-create col-lg-8 offset-lg-2">

            <h1>Update Apply Coin</h1>
    <h5 class="mb-3">Manage Coins needed to apply for job according to region</h5>

            <div class="card">
                <div class="card-body">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>

