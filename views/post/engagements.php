<?php

use app\components\Helper;
use yii\helpers\Html;

$this->title = 'Post Engagement Details';
$this->params['breadcrumbs'][] = ['label' => 'Student Job Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body {
        background-color: #F4F5F7;
        font-family: 'Poppins', sans-serif;
    }

    .expertTutor_jobDetail_container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 15px 30px;
        background: white;
        border-radius: 16px;
        margin-bottom: 5rem;
    }

    .expertTutor_jobDetail_layout {
        display: grid;
        grid-template-columns: 1fr 550px;
        gap: 24px;
        margin-top: 24px;
        margin-bottom: 24px;
        background-color: white;
    }

    .expertTutor_jobDetail_mainContent {
        min-width: 0;
    }

    .expertTutor_jobDetail_sidebar {
        min-width: 0;
        background: #F4F5F7;
        padding: 1rem;
        border-radius: 10px;
        height: 400px;
        /* overflow: scroll; */
        overflow-y: auto;
        /* Prevent horizontal scroll */
        /* place-content: center; */

    }

    .expertTutor_jobDetail_clientsList {
        display: flex;
        flex-direction: column;
    }

    .expertTutor_jobDetail_clientCard {
        display: flex;
        gap: 12px;
        background: #F9FAFB;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border: 1px solid transparent;
        position: relative;
        margin-bottom: 10px;
    }

    .expertTutor_jobDetail_clientCard.active {
        background: #e4e6e97a;
        border-color: #E5E7EB;
    }

    .expertTutor_jobDetail_clientCard:hover {
        background: #F4F5F7;
    }

    .expertTutor_jobDetail_clientAvatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .expertTutor_jobDetail_clientInfo {
        flex: 1;
        min-width: 0;
        color: #9CA3AF;
    }

    .expertTutor_jobDetail_clientCard.active .expertTutor_jobDetail_clientInfo {
        color: inherit;
    }

    .expertTutor_jobDetail_clientCard.active .expertTutor_jobDetail_clientInfo .expertTutor_jobDetail_clientName {
        color: #1B1B3F;
    }

    .expertTutor_jobDetail_clientCard.active .expertTutor_jobDetail_clientInfo .expertTutor_jobDetail_clientDescription {
        color: #6B7280;
    }

    .expertTutor_jobDetail_clientName {
        font-size: 1rem;
        font-weight: 600;
        color: #1b1b3fa6;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .expertTutor_jobDetail_clientDescription {
        color: #6b7280a6;
        font-size: 0.875rem;
        line-height: 1.5;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .expertTutor_jobDetail_notificationDot {
        width: 30px;
        height: 30px;
        background: #FF4842;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 500;
        position: absolute;
        top: -10px;
        right: -10px;
    }

    @media (max-width: 992px) {
        .expertTutor_jobDetail_layout {
            grid-template-columns: 1fr;
        }

        .expertTutor_jobDetail_meta {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }

    .expertTutor_jobDetail_card {
        background: white;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .expertTutor_jobDetail_header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        border-bottom: 1px solid #E5E7EB;
        padding-bottom: 24px;
    }

    .expertTutor_jobDetail_title {
        font-size: clamp(1rem, 1vw + 1rem, 1.4rem) !important;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 6px;
        line-height: 1.2;
    }

    .expertTutor_jobDetail_meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
    }

    .expertTutor_jobDetail_price {
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .expertTutor_jobDetail_currency {
        font-weight: 300;
        color: #564FFD;
        font-size: 1rem;
    }

    .expertTutor_jobDetail_location {
        color: #6B7280;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .expertTutor_jobDetail_location svg {
        color: #09B31A;
        width: 16px;
        height: 16px;
    }

    .expertTutor_jobDetail_status {
        background: #F3F4F6;
        color: #6B7280;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-block;
        margin-top: 8px;
    }

    .expertTutor_jobDetail_description {
        color: #6B7280;
        font-size: 0.875rem;
        line-height: 0.8;
        margin: 0;
        white-space: pre-line;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9e8e8;
    }

    .expertTutor_jobDetail_section {
        margin-bottom: 24px;
    }

    .expertTutor_jobDetail_sectionTitle {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1B1B3F;
        margin-bottom: 16px;
    }

    .expertTutor_jobDetail_actions {
        display: flex;
        gap: 16px;
        margin-top: 12px;
    }

    .expertTutor_jobDetail_finishButton {
        background-color: #564FFD;
        border: none;
        color: white;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s;
        font-size: 0.8rem;
    }

    .expertTutor_jobDetail_finishButton:hover {
        background-color: #4F46E5;
        color: white;
        text-decoration: none;
    }

    .expertTutor_jobDetail_messageButton {
        background-color: white;
        border: 1px solid #E5E7EB;
        color: #1B1B3F;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 0.8rem;
    }

    .expertTutor_jobDetail_messageButton:hover {
        background-color: #F9FAFB;
        border-color: #D1D5DB;
        color: #1B1B3F;
        text-decoration: none;
    }

    .expertTutor_jobDetail_messageButton i {
        color: #09B31A;
    }

    .badge {
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-info {
        background-color: gray;
        color: white;
    }

    .badge-success {
        background-color: #10B981;
        color: white;
        place-content: center;
    }

    .badge-danger {
        background-color: #EF4444;
        color: white;
    }

    .eng_action_btns a {
        white-space: nowrap;
    }
</style>
<div class="container mt-4 mb-5">
    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
        <a href="javascript:void(0);" onclick="window.history.back();" style="color: #6c757d; text-decoration: none; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa fa-arrow-left"></i> Go Back
        </a>
    </div>
    <div class="expertTutor_jobDetail_container">
        <div class="expertTutor_jobDetail_layout">
            <!-- Left Column: Job Details -->
            <div class="expertTutor_jobDetail_mainContent">
                <div class="expertTutor_jobDetail_card">
                    <h1 class="expertTutor_jobDetail_title"><?= Html::encode($post->title) ?></h1>
                    <p class="expertTutor_jobDetail_description">
                        <?= Html::encode(mb_substr($post->details, 0, 500)) . (mb_strlen($post->details) > 500 ? '...' : '') ?>
                    </p>
                    <div class="expertTutor_jobDetail_meta">
                        <div class="expertTutor_jobDetail_price">
                            <span class="expertTutor_jobDetail_currency"><?= Helper::getCurrency() ?></span>
                            <?= Html::encode($post->budget) ?>
                        </div>
                        <div class="expertTutor_jobDetail_location">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1983_3041)">
                                    <path d="M21.5801 10.2247C21.5801 17.2247 12.5801 23.2247 12.5801 23.2247C12.5801 23.2247 3.58008 17.2247 3.58008 10.2247C3.58008 7.83775 4.52829 5.54857 6.21612 3.86074C7.90394 2.17291 10.1931 1.2247 12.5801 1.2247C14.967 1.2247 17.2562 2.17291 18.944 3.86074C20.6319 5.54857 21.5801 7.83775 21.5801 10.2247Z" stroke="#09B31A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.5801 13.2247C14.2369 13.2247 15.5801 11.8816 15.5801 10.2247C15.5801 8.56785 14.2369 7.2247 12.5801 7.2247C10.9232 7.2247 9.58008 8.56785 9.58008 10.2247C9.58008 11.8816 10.9232 13.2247 12.5801 13.2247Z" stroke="#09B31A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1983_3041">
                                        <rect width="24" height="24" fill="white" transform="translate(0.580078 0.224701)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <?= Html::encode($post->location) ?>
                        </div>
                    </div>
                    <?php /*?>
                    <div class="expertTutor_jobDetail_status">
                        <?= $post->post_status === 'finished' ? 'Post Closed' : 'Open' ?>
                    </div>
                    <?php */ ?>
                    <div class="expertTutor_jobDetail_actions">
                        <?php if ($post->post_status !== 'complete'): ?>
                            <?= Html::a('Mark Complete', ['finish-post', 'id' => $post->id], [
                                'class' => 'expertTutor_jobDetail_finishButton',
                                'data' => [
                                    'confirm' => 'Are you sure you want to mark this post as completed/finished?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                        <?= Html::a('View Details', ['view', 'id' => $post->id], ['class' => 'expertTutor_jobDetail_messageButton']) ?>
                    </div>
                </div>
            </div>
            <!-- Right Column: Messages/Clients -->
            <div class="expertTutor_jobDetail_sidebar ">
                <div class="expertTutor_jobDetail_clientsList chat-messages">
                    <?php if (!empty($post->messages)): ?>
                        <?php foreach ($post->messages as $i => $message): ?>
                            <?php //$i === 0 ? ' active' : '' 
                            ?>
                            <div class="expertTutor_jobDetail_clientCard" data-post-id="<?= $post->id ?>" data-sender-id="<?= $message->sender_id ?>">

                                <img src="<?= Html::encode($message->sender->profile_image ?? ('https://ui-avatars.com/api/?name=' . Html::encode($message->sender->username))) ?>" alt="<?= Html::encode($message->sender->username) ?>" class="expertTutor_jobDetail_clientAvatar">
                                <div class="expertTutor_jobDetail_clientInfo">
                                    <div class="expertTutor_jobDetail_clientName">
                                        <?= Html::encode($message->sender->username) ?>
                                    </div>
                                    <div class="message-content">
                                        <p><?= Html::encode($message->message) ?></p>
                                    </div>
                                    <div class="gap-1 d-flex text-right justify-content-end eng_action_btns">
                                        <?php 
                                        // Check current application status from database
                                        $applicationStatus = Yii::$app->db->createCommand("
                                            SELECT application_status FROM job_applications 
                                            WHERE job_id = :post_id AND applicant_id = :tutor_id
                                        ", [':post_id' => $post->id, ':tutor_id' => $message->sender_id])->queryScalar();
                                        ?>
                                        
                                        <?php 
                                        // Check if post is assigned to another tutor
                                        $assignedTutor = Yii::$app->db->createCommand("
                                            SELECT applicant_id FROM job_applications 
                                            WHERE job_id = :post_id AND application_status = 'accepted'
                                        ", [':post_id' => $post->id])->queryScalar();
                                        ?>
                                          <?php $user_slug= Helper::getuserslugfromid($message->sender_id);?>
                                          <a class="btn btn-sm btn-info text-white" href="<?php echo Helper::baseUrl("tutor-profile?id={$user_slug}") ?>"> View Profile</a>
                                         <a class="btn btn-sm btn-info text-white" href="<?php echo Helper::baseUrl("/peoples/chat?other={$user_slug}") ?>"> Message</a>

                                         
                                        
                                        <?php if ($applicationStatus === 'accepted'): ?>
                                            <a href="#" class=" btn btn-sm btn-success">Accepted</a>
                                        <?php elseif ($applicationStatus === 'rejected'): ?>
                                            <a href="#" class=" btn btn-sm  btn-danger">Rejected</a>
                                        <?php elseif ($assignedTutor && $assignedTutor != $message->sender_id): ?>
                                            <span class="badge badge-info">Post Assigned to Another Tutor</span>
                                        <?php else: ?>
                                            <a class="btn btn-sm btn-success accept-request" 
                                               data-post-id="<?= $post->id ?>" 
                                               data-sender-id="<?= $message->sender_id ?>"
                                               data-message-id="<?= $message->id ?>"> Accept Request</a>
                                            <a class="btn btn-sm btn-secondary reject-request" 
                                               data-post-id="<?= $post->id ?>" 
                                               data-sender-id="<?= $message->sender_id ?>"
                                               data-message-id="<?= $message->id ?>"> Reject Request</a>
                                        <?php endif; ?>
                                         
                                      
                                    </div>

                                </div>
                                <?php
                                // Count unread messages for this sender in this post
                                $unreadCount = 0;
                                if (isset($message->sender->id) && isset($post->messages)) {
                                    foreach ($post->messages as $msg) {
                                        if (
                                            $msg->sender_id == $message->sender->id &&
                                            isset($msg->is_read) && !$msg->is_read
                                        ) {
                                            $unreadCount++;
                                        }
                                    }
                                }
                                ?>
                                <?php if ($unreadCount > 0): ?>
                                    <span class="expertTutor_jobDetail_notificationDot"><?= $unreadCount ?></span>
                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="color:#888; text-align:center; padding: 2rem;">
                            <i class="fa fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.6;"></i>
                            <p style="margin: 0; font-size: 1rem;">No messages found for this post.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
    const secretkeyForEncryption = "random1000secret1000keys";
    // Function to encrypt text
    function encryptText(text, secretKey) {
        return CryptoJS.AES.encrypt(text, secretKey).toString();
    }

    // Function to decrypt text
    function decryptText(encryptedText, secretKey) {
        let bytes = CryptoJS.AES.decrypt(encryptedText, secretKey);
        return bytes.toString(CryptoJS.enc.Utf8);
    }
    var isEnc = false;
    const isMessages = document.querySelector(".chat-messages");
    //alert(isMessages);
    if (isMessages) {
        document.querySelectorAll(".message-content").forEach(m => {
            let p = m.children[0];
            isEnc = false;
            p.textContent = decryptText(p.textContent, secretkeyForEncryption);
        });
    }

       // Handle accept/reject requests with event delegation
    $(document).on('click', '.accept-request, .reject-request', function(e) {
        e.preventDefault();
        const $this = $(this);
        const isAccept = $this.hasClass('accept-request');
        const postId = $this.data('post-id');
        const senderId = $this.data('sender-id');
        const messageId = $this.data('message-id');

        Swal.fire({
            title: 'Confirm',
            text: `Are you sure you want to ${isAccept ? 'accept' : 'reject'} this request?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#09B31A',
            cancelButtonColor: '#564FFD',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                const action = isAccept ? acceptRequest : rejectRequest;
                action(postId, senderId, messageId, $this[0]);
            }
        });
    });

    function acceptRequest(postId, senderId, messageId, buttonElement) {
        // Show loading state
        buttonElement.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        buttonElement.disabled = true;

        // Send AJAX request to backend
        fetch('<?= Helper::baseUrl("/post/accept-request") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                post_id: postId,
                sender_id: senderId,
                message_id: messageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI to show accepted state
                const card = buttonElement.closest('.expertTutor_jobDetail_clientCard');
                const actionButtons = card.querySelector('.accept-request');
                actionButtons.innerHTML = 'Accepted';
                
                // Disable all other accept/reject buttons for this post
                document.querySelectorAll('.accept-request, .reject-request').forEach(btn => {
                    if (btn.getAttribute('data-post-id') === postId) {
                        btn.style.display = 'none';
                    }
                });

                const rejectBtn = card.querySelector('.reject-request');


                if (rejectBtn) rejectBtn.style.display = 'none';
                
                toastr.success('Request accepted successfully!');
            } else {
                toastr.error(data.message || 'Failed to accept request');
                buttonElement.innerHTML = 'Accept Request';
                buttonElement.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
             toastr.error('An error occurred while processing the request');
            buttonElement.innerHTML = 'Accept Request';
            buttonElement.disabled = false;
        });
    }

    function rejectRequest(postId, senderId, messageId, buttonElement) {
        // Show loading state
        buttonElement.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        buttonElement.disabled = true;

        // Send AJAX request to backend
        fetch('<?= Helper::baseUrl("/post/reject-request") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                post_id: postId,
                sender_id: senderId,
                message_id: messageId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI to show rejected state
                const card = buttonElement.closest('.expertTutor_jobDetail_clientCard');
                const actionButtons = card.querySelector('.reject-request');
                actionButtons.innerHTML = 'Rejected';
                
                // Hide the accept/reject buttons for this specific message
                const acceptBtn = card.querySelector('.accept-request');
                if (acceptBtn) acceptBtn.style.display = 'none';
                
                
                
                 toastr.success('Request rejected successfully!');
            } else {
                 toastr.error(data.message || 'Failed to reject request');
                buttonElement.innerHTML = 'Reject Request';
                buttonElement.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
             toastr.error('An error occurred while processing the request');
            buttonElement.innerHTML = 'Reject Request';
            buttonElement.disabled = false;
        });
    }


    
</script>