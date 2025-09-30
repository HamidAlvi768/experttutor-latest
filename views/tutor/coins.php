<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Get Coins';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="p-5">

    <!-- HEADER -->
    <div class="row">
        <div class="w-100 bg-secondary text-dark p-5 rounded">
            <div class="text-center">
                <h1><?= $user->username ?></h1>
            </div>
        </div>
    </div>
    <!-- HEADER -->

    <div class="container">
        <div class="text-center" style="padding: 40px;">

            <div class="coin-form">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['/tutor/wallet/coins'], // Adjust controller/action as needed
                ]); ?>

                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <?php foreach ($coins as $coin): ?>
                        <div class="coin-select"
                            style="width: fit-content; padding: 5px 15px; border: 1px solid blue; border-radius: 5px; cursor: pointer;"
                            onclick="this.querySelector('input[type=radio]').checked = true;">
                            <?= Html::radio('coin', false, [
                                'value' => $coin->id,
                                'uncheck' => null, // Prevents sending unchecked value
                            ]) ?>
                            <p><?= Html::encode($coin->coin_count) ?> Coins (<?= Html::encode($coin->coin_price) ?> <?= Helper::getCurrency() ?>)</p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <br>

                <div class="form-group">
                    <?= Html::submitButton('Continue', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>