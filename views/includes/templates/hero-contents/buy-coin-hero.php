<?php

namespace app\controllers;

use Yii;
use app\components\Helper;
?>
<?php
$initialView = true; // You can set this based on session/state management
?>
<style>
    .coin-packages .package-content {
        white-space: nowrap;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('../custom/images/hero-image.jpg') center/cover no-repeat fixed;
        z-index: -2;
        opacity: 0.1;
    }

    /* Specific styles for buy-coin hero content */
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

    .hero-title .highlight {
        color: var(--primary-color);
    }

    .hero-title .subtitle {
        font-size: 2rem;
        margin-top: 0px;
        font-weight: 400;
        letter-spacing: 2px;
        text-align: center;
    }

    .btn-buy-coins {
        margin-bottom: 30px;
    }

    .payment-methods {
        text-align: center;
    }

    .payment-text {
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .payment-logos {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .payment-logos img {
        height: 60px;
        width: auto;
        opacity: 0.9;
        transition: var(--transition);
    }

    .payment-logos img:hover {
        opacity: 1;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .hero-title .main-title {
            font-size: 3.5rem;
        }

        .hero-title .subtitle {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .hero-title .main-title {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            white-space: normal;
            display: flex;
            flex-wrap: wrap;
            width: max-content;
            align-items: baseline;
            margin: 0 auto;
        }

        .hero-title .subtitle {
            font-size: 1.8rem;
        }

        .payment-logos img {
            height: 65px;
        }
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-container {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 800px;
        margin: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--primary-color);
        border-radius: 0 0 16px 16px;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--text-light);
        cursor: pointer;
        padding: 0;
        transition: var(--transition);
    }

    .close-modal:hover {
        color: var(--text-dark);
    }

    .modal-content {
        padding: 2rem;
    }

    .coin-packages {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem;
    }

    .coin-package {
        flex: 1;
        border: 1px solid #e1e1e1;
        border-radius: 25px;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f8f9ff;
    }

    .coin-package:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-color);
    }

    .coin-package.selected {
        border-color: var(--primary-color);
        background: rgba(86, 79, 253, 0.02);
    }

    .package-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .coin-icon {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .package-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .coin-amount {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-dark);
        width: max-content;
    }

    .coin-price {
        font-size: 1rem;
        color: var(--text-light);
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-buy-now {
        background: var(--primary-color);
        color: white;
        border: none;
        width: 100%;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-buy-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(86, 79, 253, 0.3);
    }

    @media (max-width: 768px) {
        .coin-packages {
            flex-direction: column;
            gap: 0.75rem;
        }

        .coin-package {
            width: 100%;
        }

        .package-content {
            justify-content: flex-start;
        }
    }

    .hidden {
        display: none;
    }

    /* New styles for coin packages section */
    .section-header {
        background: var(--primary-color);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .section-header h2 {
        color: white;
        text-align: center;
        margin: 0;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .coin-packages {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
        margin-inline: 1rem;
    }

    .coin-package {
        border: 1px solid #e1e1e1;
        border-radius: 15px;
        padding: 0.75rem 1.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f8f9ff;
    }

    .coin-package:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-color);
    }

    .coin-package.selected {
        background: var(--primary-color);
    }

    .coin-package.selected .coin-amount,
    .coin-package.selected .coin-price {
        color: white;
    }

    .package-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .package-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .coin-amount {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-dark);
    }

    .coin-price {
        font-size: 1rem;
        color: var(--text-light);
    }

    .coin-icon {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        margin-right: 1.5rem;
    }

    .btn-cancel {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        background: white;
        color: var(--text-dark);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-continue {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        background: var(--primary-color);
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover,
    .btn-continue:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .coin-packages {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .coin-packages {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-continue {
            width: 100%;
        }
    }

    #initialContent {
        text-align: center;
    }

    #coinPackagesSection {
        background: white;
        padding: 2rem;
        padding-bottom: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
    }

    #initialContent {
        text-align: center;
    }
</style>

<div class="hero-title">
    <div class="main-title">BUY <span class="highlight">COIN</span> TO GET</div>
    <div class="subtitle">TEACHING JOB</div>
    <div class="subtitle" style="margin-top: 20px; font-size: 1.5rem; color: var(--primary-color); font-weight: 500;">

        Coin Wallet: <?= number_format($wallet->balance) ?>
    </div>
</div>

<div id="initialContent" class="<?php echo !$initialView ? 'hidden' : ''; ?>">
    <button class="btn-primary btn-buy-coins" onclick="showCoinPackages()">Buy Coins</button>

</div>

<div id="coinPackagesSection" class="<?php echo $initialView ? 'hidden' : ''; ?>">
    <div class="section-header">
        <h2>How Many Coin You Buy</h2>
    </div>
    <div class="coin-form">
        <?php

        use yii\helpers\Html;
        use yii\widgets\ActiveForm; ?>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['/tutor/wallet/coins'],
        ]); ?>
        <div class="coin-packages">
            <?php foreach ($coins as $coin): ?>
                <label class="coin-package<?php if ($coin === reset($coins)) echo ' selected'; ?>" onclick="selectRadio(this)">
                    <?php /*= Html::radio('coin', false, [
                        'value' => $coin->id,
                        'uncheck' => null,
                        'style' => 'display:none;',
                    ]) */ ?>
                    <?= Html::radio('coin', $coin === reset($coins), [
                        'value' => $coin->id,
                        'uncheck' => null,
                        'style' => 'display:none;',
                    ]) ?>

                    <div class="package-content">
                        <div class="package-text">
                            <span class="coin-amount"><?= Html::encode($coin->coin_count) ?> Coins</span>
                            <?php if (!empty($coin->discount) && $coin->discount > 0): ?>
                                <?php
                                $originalPrice = $coin->coin_price;
                                $discountedPrice = $originalPrice - ($originalPrice * ($coin->discount / 100));
                                ?>

                                <span class="coin-price">
                                    <span style="text-decoration: line-through; color: #b0b0b0;">
                                        <?= Html::encode($originalPrice) ?> <?= Helper::getCurrency() ?>
                                    </span>
                                    <span>
                                        <?= Html::encode($discountedPrice) ?> <?= Helper::getCurrency() ?>
                                    </span>
                                </span>
                            <?php else: ?>
                                <span class="coin-price">
                                    <?= Html::encode($coin->coin_price) ?> <?= Helper::getCurrency() ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <img src="<?= Helper::baseUrl("/") ?>custom/images/icons/coin-stack.png" alt="Coins" class="coin-icon">
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
        <div class="action-buttons">
            <button type="button" class="btn-cancel" onclick="hidePackages()">Cancel</button>
            <?= Html::submitButton('Continue', ['class' => 'btn-continue']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


<script>
    function showCoinPackages() {
        document.getElementById('initialContent').classList.add('hidden');
        document.getElementById('coinPackagesSection').classList.remove('hidden');
    }

    function hidePackages() {
        document.getElementById('coinPackagesSection').classList.add('hidden');
        document.getElementById('initialContent').classList.remove('hidden');
    }

    function selectRadio(element) {
        document.querySelectorAll('.coin-package').forEach(pkg => pkg.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input[type=radio]').checked = true;
    }
</script>