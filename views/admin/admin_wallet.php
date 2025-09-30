<?php

use app\components\Helper;
use app\models\User;
use yii\helpers\BaseUrl;
use yii\helpers\Html;

$this->title = 'Tutor Wallet';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Page specific variables
$page_title = 'Buy Coins';
$page_class = 'buy-coin-page';
$hero_content = '/includes/templates/hero-contents/buy-coin-hero.php';
$additional_css = [];
?>
<style>
    .wallet-hero {
        /* max-width: 500px; */
        margin: 40px auto 32px auto;
        background: linear-gradient(90deg, #e0eafc 0%, #cfdef3 100%);
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        padding: 36px 32px 28px 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .wallet-hero .wallet-icon {
        /* width: 60px; */
        /* height: 60px; */
        margin-bottom: 18px;
    }

    .wallet-hero .wallet-balance {
        font-size: 2.8rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 8px;
    }

    .wallet-hero .wallet-label {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 18px;
    }

    .wallet-hero .btn-get-coins {
        background: #2ecc71;
        color: #fff;
        border-radius: 8px;
        padding: 12px 32px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        transition: background 0.2s;
        margin-top: 10px;
        display: inline-block;
    }

    .wallet-hero .btn-get-coins:hover {
        background: #27ae60;
    }

    .wallet-transactions-section {

        margin: 0 auto 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        padding: 32px 32px 24px 32px;
    }

    .wallet-transactions-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .wallet-transactions-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .wallet-transactions-table th,
    .wallet-transactions-table td {
        padding: 14px 12px;
        text-align: left;
        font-size: 1rem;
    }

    .wallet-transactions-table th {
        background: #f8fafc;
        color: #564FFD;
        font-weight: 600;
        border-bottom: 2px solid #eaeaea;
    }

    .wallet-transactions-table tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .wallet-transactions-table td {
        color: #444;
    }

    .wallet-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 12px;
        font-size: 0.98rem;
        font-weight: 600;
    }

    .wallet-badge.credit {
        background: #e8f9f1;
        color: #2ecc71;
    }

    .wallet-badge.debit {
        background: #ffeaea;
        color: #e74c3c;
    }

    @media (max-width: 700px) {

        .wallet-hero,
        .wallet-transactions-section {
            padding: 18px 8px;
        }

        .wallet-hero {
            max-width: 98vw;
        }

        .wallet-transactions-section {
            max-width: 99vw;
        }
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 20px;
        text-transform: uppercase;
        gap: 0px;
    }

    .hero-title .main-title {
        white-space: nowrap;
        font-size: 4.5rem;
        letter-spacing: 2px;
    }

    .hero-title .subtitle {
        font-size: 2rem;
        margin-top: 10px;
        font-weight: 400;
        letter-spacing: 2px;
        text-align: center;
    }

    .hero-content-container {
        margin-bottom: 5px !important;
    }

    .btn-recharge {
        background: #564FFD;
        color: white;
        border: none;
        padding: 15px 82px;
        font-size: 1.2rem;
        font-weight: 400;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        text-decoration: none;
    }

    #initialContent {
        text-align: center;
    }
    .modal-overlay {
  background-color: rgba(0, 0, 0, 0.5) !important; /* black with transparency */
}

</style>
<div class="page-wrapper">
    <div class="content">
        <div class="container hero-content-container">
            <div class="hero-content p-0">


                <div class="hero-title">
                    <div class="subtitle" style="margin-top: 20px; font-size: 1.5rem; color: var(--primary-color); font-weight: 500;">
                        Wallet Coins: <?= number_format($my_wallet->balance) ?> </div>
                </div>

                <div id="initialContent" class="">
                    <button class=" btn-buy-coins btn-recharge " data-toggle="modal" data-target="#exampleModalCenter">Recharge Coins</button>

                </div>



            </div>
        </div>
        <!-- Statistics Cards -->
        <div class="wallet-transactions-section container">
           <!-- Add this right below the <h3>Transactions</h3> heading -->
<div class="row mb-3">
    <div class="col-md-6">
        <h3>Transactions</h3>
    </div>
    <div class="col-md-6 text-right">
        <div class="form-inline justify-content-end">
            <label for="per-page" class="mr-2">Show:</label>
            <select id="per-page" class="form-control form-control-sm" onchange="updatePerPage(this.value)">
                <option value="10" <?= $pagination->pageSize == 10 ? 'selected' : '' ?>>10</option>
                <option value="50" <?= $pagination->pageSize == 50 ? 'selected' : '' ?>>50</option>
                <option value="100" <?= $pagination->pageSize == 100 ? 'selected' : '' ?>>100</option>
                <option value="500" <?= $pagination->pageSize == 500 ? 'selected' : '' ?>>500</option>
            </select>
            <span class="ml-2">entries</span>
        </div>
    </div>
</div>



            <?php if (count($transactions) > 0): ?>
                <table class="wallet-transactions-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $index => $transaction): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <span class="wallet-badge <?= $transaction->transaction_type == 'credit' ? 'credit' : 'debit' ?>">
                                        <?= ucfirst(Html::encode($transaction->transaction_type)) ?>
                                    </span>
                                </td>
                                <td><?= Html::encode($transaction->description) ?></td>
                                <td>
                                    <?php if ($transaction->transaction_type == 'credit'): ?>
                                        <span style="color:#2ecc71;">+<?= Html::encode(number_format($transaction->amount)) ?></span>
                                    <?php else: ?>
                                        <span style="color:#e74c3c;">-<?= Html::encode(number_format($transaction->amount)) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= Yii::$app->formatter->asDatetime($transaction->created_at, 'php:M d, Y h:i A') ?></td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
  
                </table>
                                    
<!-- Pagination outside the table -->
<div class="d-flex justify-content-center mt-3">
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['class' => 'page-link'],
        'pageCssClass' => 'page-item',
        'prevPageCssClass' => 'page-item',
        'nextPageCssClass' => 'page-item',
        'activePageCssClass' => 'active',
        'disabledPageCssClass' => 'disabled',
        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
        'prevPageLabel' => '&laquo;',
        'nextPageLabel' => '&raquo;',
    ]) ?>
</div>       
            <?php else: ?>
                <p style="color:#888; font-size:1.1rem;">No transactions yet!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Recharge Coins</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= \yii\helpers\Url::to(['admin/recharge']) ?>">
                    <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Recharge Coin Amount</label>
                        <input type="number" name="coin_count" class="form-control" id="exampleInputEmail1" aria-describedby="Help" placeholder="Enter Coin Amount" required min="1">
                        <small id="Help" class="form-text text-muted">Enter the amount of coins you want to recharge.</small>
                    </div>

<div class="form-group">
    <label for="verificationCode">Enter The Verification Code</label>
    <div class="input-group">
        <input type="text" name="code" class="form-control" id="verificationCode" 
               aria-describedby="codeHelp" placeholder="Enter Code" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" id="sendCodeBtn">
                <span class="btn-text2 ">Send Code</span>
                <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <small id="codeHelp" class="form-text text-muted">Enter the verification code sent to your email</small>
</div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>

        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    $('#per-page').change(function() {
        var perPage = $(this).val();
        var url = new URL(window.location.href);
        
        // Update or add the per-page parameter
        url.searchParams.set('per-page', perPage);
        
        // Reset to first page when changing page size
        url.searchParams.delete('page');
        
        // Reload the page with new parameters
        window.location.href = url.toString();
    });
});
JS);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendCodeBtn = document.getElementById('sendCodeBtn');
    let countdown = 0;
    let countdownInterval;

    sendCodeBtn.addEventListener('click', function() {
        // Disable button immediately
        this.disabled = true;
        const originalText = this.textContent;
        this.textContent = 'Sending...';

        // Make AJAX call
        fetch('<?= Yii::$app->urlManager->createUrl('admin/verification') ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success - show SweetAlert and start countdown
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                });
                
                startCountdown(60);
            } else {
                // Error - show SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
                
                // Re-enable button on error
                sendCodeBtn.disabled = false;
                sendCodeBtn.textContent = originalText;
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network error occurred'
            });
            
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = originalText;
        });
    });

    function startCountdown(seconds) {
        clearInterval(countdownInterval);
        countdown = seconds;
        
        countdownInterval = setInterval(function() {
            countdown--;
            sendCodeBtn.textContent = 'Resend (' + countdown + 's)';
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                sendCodeBtn.textContent = 'Resend';
                sendCodeBtn.disabled = false;
            }
        }, 1000);
    }
});
</script>