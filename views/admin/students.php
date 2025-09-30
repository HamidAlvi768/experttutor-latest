<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Helper;

?>


    <?php  //print_r($users);?>
    <table id="userTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>User Status</th>
                <th>Verification</th>
                <th>Join Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $i => $user): ?>
            <tr>
                <td><?= Html::encode($user['username']) ?></td>
                <td><?= Html::encode($user['email']) ?></td>
                <td><?= Html::encode($user['user_status'] ? 'Active' : 'Not Active') ?></td>
                <td>
                    <?= $user['verification'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?>
                </td>
                <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                <td>
                    <a href="<?= Helper::baseUrl(['user/edit', 'id' => $user['id']]) ?>"
                        class="btn btn-sm btn-primary">Edit</a>

                    <a href="<?= Helper::baseUrl(['user/delete', 'id' => $user['id']]) ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure to delete this user?')">Delete</a>

                    <?php if (!$user['verification']): ?>
                    <a href="<?= Helper::baseUrl(['user/verify', 'id' => $user['id']]) ?>"
                        class="btn btn-sm btn-success">Verify</a>
                    <?php else: ?>
                    <span class="btn btn-sm btn-outline-success disabled">Verified</span>
                    <?php endif; ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

