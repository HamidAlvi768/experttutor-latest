<?php
/** @var yii\web\View $this */

use app\components\Helper;
use app\models\Membership;
use yii\helpers\Url;
use app\models\User; // Assuming User model for wallet access

$user = Yii::$app->user->identity;
$userWallet = $user ? $user->wallet : null;
$totalActiveCoins = Membership::getTotalActiveCoins($user->id);
$totalAutoRenewal = Membership::getTotalRenewal($user->id);

$isMember = Membership::hasActiveMembership($user->id);
$purchases = Membership::getUserMemberships($user->id);
$latestExpiry = null;

if ($purchases) {
    $expiryTimestamps = array_filter(array_map(function($p) {
        return $p->memb_expiry ? strtotime($p->memb_expiry) : null;
    }, $purchases));

    if (!empty($expiryTimestamps)) {
        $latestExpiry = max($expiryTimestamps);
    }
}
?>
<style>
    .coin-icon {
        width: 40px;
        height: 40px;
        margin-right: 10px;
        vertical-align: middle;
    }
    .current-coins {
        background: var(--primary-color);
        color: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .expired-coins {
        background: var(--primary-color);
        color: white;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    .membership-status {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    .status-badge {
        background: var(--success-color);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 3px;
        font-size: 0.8rem;
        margin-left: 0.5rem;
    }
    .cancel-btn {
        background: #f56565;
        color: white;
        border: none;
        padding: 5px 15px;
        font-weight: bold;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
        transition: background 0.3s;
    }
    .cancel-btn:hover {
        background: #e53e3e;
    }
    .buy-now-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
        width: auto;
    }
    .buy-now-btn:hover {
        background: #4c51bf;
        color: white;
    }
    .modal-content {
        border-radius: 10px;
    }
    .modal-header {
        background: var(--primary-color);
        color: white;
        border-radius: 10px 10px 0 0;
    }
    .modal-body {
        padding: 2rem;
    }
    .coin-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 18px;
        text-align: center;
    }
    .submit-btn {
        background: var(--success-color);
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: bold;
        border-radius: 5px;
        width: 100%;
        margin-top: 1rem;
    }
    .submit-btn2 {
        width: auto !important;
    }
    .auto-renew-toggle {
        display: flex;
        align-items: center;
        margin-top: 1rem;
        gap: 0.5rem;
    }
    .auto-renew-toggle label {
        margin-bottom: 0;
        cursor: pointer;
    }
    .auto-renew-info {
        background: #e7f3ff;
        border: 1px solid #bee5eb;
        border-radius: 5px;
        padding: 0.75rem;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #0c5460;
    }
    .purchases-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    .table {
        margin-bottom: 0;
    }
    .table th {
        background: var(--primary-color);
        color: white;
        font-weight: 600;
        text-align: center;
    }
    .table td {
        vertical-align: middle;
        text-align: center;
    }
    .no-purchases {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        padding: 2rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <?php if ($isMember): ?>
                <div class="current-coins">
                    <h3><i class="fas fa-coins me-2"></i>Total Active Membership Coins: <strong><?= number_format($totalActiveCoins) ?></strong></h3>
                    <p>Next expiry: <?= Yii::$app->formatter->asDate($latestExpiry) ?></p>
                    <!-- <p> Auto Renew Total: <?php // number_format($totalAutoRenewal) ?></p> -->
                </div>
            <?php else: ?>
                <div class="expired-coins">
                    <h3><i class="fas fa-exclamation-triangle me-2"></i>No Active Membership</h3>
                    <p>Buy now to apply instantly to jobs!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="text-center mt-4 mb-4">
        <button class="submit-btn submit-btn2" data-bs-toggle="modal" data-bs-target="#buyModal">BUY NOW</button>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="purchases-table">
                <?php if (!empty($purchases)): ?>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Purchase Date</th>
                                <th>Coins</th>
                                <th>Expiry Date</th>
                                <th>Auto-Renew</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchases as $purchase): ?>
                                <tr>
                                    <td><?= Yii::$app->formatter->asDate($purchase->created_at) ?></td>
                                    <td><strong><?= number_format($purchase->premium_coins) ?></strong></td>
                                    <td><?= Yii::$app->formatter->asDate($purchase->memb_expiry) ?>
                                        <?php if (strtotime($purchase->memb_expiry) < time()): ?>
                                            <span class="text-danger">(expired)</span>
                                        <?php endif; ?></td>
                                    <td>
                                        <?php if ($purchase->auto_renew): ?>
                                            <span class="status-badge">Enabled</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Disabled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($purchase->auto_renew): ?>
                                            <button class="cancel-btn" onclick="cancelAutoRenew(<?= $purchase->id ?>)">
                                                Cancel AutoRenew
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>


</div>

<!-- Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyModalLabel">Buy New Membership Pack</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This will create a new pack valid for 30 days. Total active coins will be the sum of all unexpired packs.</p>
                <form method="post" action="<?= Url::to(['tutor/buy-membership']) ?>">
                    <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                    <input type="number" name="custom_coins" class="coin-input" min="1" placeholder="Enter coins (e.g., 100)" required>
                    
                    <small class="form-text text-muted">
                        Note: This pack expires in 30 days. Auto-renew renews only this pack's coins.
                    </small>
                    
                    <div class="auto-renew-toggle">
                        <input type="checkbox" id="autoRenew" name="auto_renew" value="1">
                        <label for="autoRenew">Enable Auto-Renew for this pack</label>
                    </div>
                    <div id="autoRenewInfo" class="auto-renew-info" style="display: none;">
                        <i class="fas fa-sync-alt"></i> These coins will auto-renew every 30 days (deduct from wallet).
                    </div>
                    
                    <button type="submit" class="submit-btn">Purchase Pack</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function cancelAutoRenew(purchaseId) {
    Swal.fire({
        title: 'Cancel Auto-Renew for this Pack?',
        text: 'This pack will expire normally; no further deductions.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f56565',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Cancel',
        cancelButtonText: 'Keep Enabled'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= Url::to(['tutor/cancel-auto-renew']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                },
                body: JSON.stringify({ purchase_id: purchaseId })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire({
                          title: 'Canceled!',
                          text: 'Auto-renew canceled for this pack.',
                          icon: 'success'
                      }).then(() => location.reload());
                  } else {
                      Swal.fire({
                          title: 'Error!',
                          text: data.message || 'Something went wrong.',
                          icon: 'error'
                      });
                  }
              }).catch(() => {
                  Swal.fire({
                      title: 'Error!',
                      text: 'Network error. Please try again.',
                      icon: 'error'
                  });
              });
        }
    });
}

// Dynamic auto-renew info
document.getElementById('autoRenew').addEventListener('change', function() {
    document.getElementById('autoRenewInfo').style.display = this.checked ? 'flex' : 'none';
});
</script>

<!-- Bootstrap JS for Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />