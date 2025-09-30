<?php

use app\components\Helper;
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
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
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
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
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
.wallet-transactions-table th, .wallet-transactions-table td {
    padding: clamp(0rem, 2vw, 0.875rem) clamp(0rem, 1.5vw, 0.75rem);
    text-align: left;
    font-size: clamp(0.75rem, 2vw, 1rem);
}
.wallet-transactions-table th {
    background: #f8fafc;
    color: #555;
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
    font-size: clamp(0.65rem, 2vw, 0.9rem);
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
    .wallet-hero, .wallet-transactions-section { padding: 18px 8px; }
    .wallet-hero { max-width: 98vw; }
    .wallet-transactions-section { max-width: 99vw; }
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
.hero-content-container
{
    margin-bottom: 5px !important;
}
</style>
<link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/base-coin.css">
<div class="container hero-content-container" >
    <div class="hero-content">
        <?php
        // This is where the custom content for each page will go
        if (isset($hero_content)) {
            echo $this->render($hero_content, [ 'coins'=> $coins,'wallet'=>$wallet]);
        }
        ?>
    </div>
</div>
<div class="wallet-transactions-section container">
    <h3>Transactions</h3>
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
                                <span style="color:#2ecc71;">+<?= Html::encode( number_format($transaction->amount)) ?></span>
                            <?php else: ?>
                                <span style="color:#e74c3c;">-<?= Html::encode( number_format($transaction->amount)) ?></span>
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
                        'options' => ['class' => 'pagination justify-content-center'], // <ul class="pagination">
                        'linkOptions' => ['class' => 'page-link'],                     // <a class="page-link">
                        'pageCssClass' => 'page-item',                                 // <li class="page-item">
                        'prevPageCssClass' => 'page-item',
                        'nextPageCssClass' => 'page-item',
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'], // For <span class="page-link"> on disabled items
                        'prevPageLabel' => '&laquo;',
                        'nextPageLabel' => '&raquo;',
                    ]) ?>
</div>     
    <?php else: ?>
        <p style="color:#888; font-size:1.1rem;">No transactions yet!</p>
    <?php endif; ?>
</div>