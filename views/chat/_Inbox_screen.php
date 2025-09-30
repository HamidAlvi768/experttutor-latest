 <div class="col-md-4 chat-screen">
            <div class="chat-header">
                <?php /*?>
                <div class="chat-header-left">
                    <img class="chat-header-avatar" src="<?= isset($other->avatar) ? htmlspecialchars($other->avatar) : Helper::baseUrl('custom/images/avatars/avatar-1.png') ?>" alt="<?= isset($other->username) ? htmlspecialchars($other->username[0]) : 'U' ?>">
                    <!-- <div class="chat-header-info">
                        <span class="chat-header-username"><?= isset($other->username) ? htmlspecialchars($other->username) : '' ?></span>
                        <span class="chat-header-status">Online - Last seen, <?= isset($other->last_seen) ? htmlspecialchars($other->last_seen) : '2:02 PM' ?></span>
                    </div> -->
                </div>
                <div class="chat-header-right">
                    <button class="chat-header-icon" id="soundButton"><i class="fas fa-volume-high"></i></button>
                    <button class="chat-header-icon"><i class="fa fa-ellipsis-h"></i></button>
                </div>
                <?php */ ?>
            </div>
            <div class="chat-header-divider"></div>
            <div class="chat-messages" id="chatMessages">
                <div class="container align-content-center  align-items-center h-100">
                    <div class="text-center">
                        <!-- Inbox Icon -->
                        <i class="fas fa-envelope  fa-2x mb-2"></i>

                        <!-- Paragraph -->
                        <p>Click to sidebar people to start chat or wait for someone message to you</p>
                    </div>

                </div>
            </div>
            <!-- <form class="message-input-bar" id="messageForm">
                <button type="button" class="input-attach-icon"><i class="fa fa-paperclip"></i></button>
                <input type="text" id="messageText" class="input-text" placeholder="Type your message here...">
                <div class="input-action-icons">
                    <button type="submit" class="input-action-icon"><i class="fa fa-paper-plane"></i></button>
                </div>
            </form> -->
        </div>