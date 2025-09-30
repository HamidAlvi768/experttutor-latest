<?php

use app\components\Helper;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Referrals';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="p-5">

    <!-- HEADER -->
    <div class="row">
        <div class="w-100 text-dark p-5 rounded">
            <div class="container">
                <p>Referrals</p>
                <div class="">
                    <p><?php echo Helper::baseUrl("/signup?referral-code={$code->referral_code}") ?></p>
                    <button type="button" id="copy-referral-code-btn">Copye Code</button>
                </div>
            </div>
        </div>
    </div>
    <!-- HEADER -->

    <div class="container">
        <!-- List of referrals in a table -->
        <div class="referrals-list mt-4">
            <?php if (count($referrals) > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Verification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($referrals as $index => $referral): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= Html::encode($referral->user->username) ?></td>
                                <td><?= Html::encode($referral->referral_status) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                    ]) ?>
                </div>
            <?php else: ?>
                <p>No referrals yet!</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
    document.getElementById('copy-referral-code-btn').addEventListener('click', function() {
        // Create a temporary input element
        var tempInput = document.createElement('input');

        // Set its value to the referral code URL
        tempInput.value = '<?php echo Helper::baseUrl("/signup?referral-code={$code->referral_code}") ?>';

        // Append it to the document body
        document.body.appendChild(tempInput);

        // Select the input value
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the selected value to the clipboard
        document.execCommand('copy');

        // Remove the temporary input element from the DOM
        document.body.removeChild(tempInput);

        // Show a success message or update button text
        alert('Referral code copied to clipboard!');
    });
</script>