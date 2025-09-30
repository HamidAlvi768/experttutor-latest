<?php 
use app\components\Helper;

 ?>
 
<div class="col-md-4 chat-screen">
                <div class="chat-header">
                    <?php ?>
                    <div class="chat-header-left">
                        <button class="chat-header-back-btn" onclick="goBack()" title="Go back">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <img class="chat-header-avatar" src="<?= isset($other->avatar) ? htmlspecialchars($other->avatar) : Helper::baseUrl('custom/images/avatars/avatar-1.png') ?>" alt="<?= isset($other->username) ? htmlspecialchars($other->username[0]) : 'U' ?>">
                        <div class="chat-header-info">
                            <span class="chat-header-username"><?= isset($other->username) ? htmlspecialchars($other->username) : '' ?></span>
                           <?php
                        $onlineThreshold = 50; // 5 minutes
                        if (isset($other->last_seen) && (time() - strtotime($other->last_seen)) < $onlineThreshold) {
                            $statusText = 'Online';
                        } else {
                            $statusText = 'Last seen ' . Yii::$app->formatter->asRelativeTime($other->last_seen);
                        }
                        ?>
                        <?php if($other->last_seen){ ?>
                        <span class="chat-header-status">
                            <?= htmlspecialchars($statusText) ?>
                        </span>
                        <?php }?>
                        </div>
                    </div>
                    <div class="chat-header-right">
                        <!-- Sound button removed -->
                    </div>
                </div>
                <div class="chat-header-divider"></div>
                <div class="chat-messages" id="chatMessages"></div>
                <form class="message-input-bar" id="messageForm">
                   <?php /*?> <button type="button" class="input-attach-icon"><i class="fa fa-paperclip"></i></button><?php */?>
                    <input type="text" id="messageText" class="input-text" placeholder="Type your message here...">
                    <div class="input-action-icons">
                        <button type="submit" class="input-action-icon"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>