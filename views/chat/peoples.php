<?php

use app\components\Helper;
use yii\helpers\Html;
?>

<style>
    :root {
        --primary: #564FFD;
        --primary-light: #6C63FF;
        --sidebar-bg: #fff;
        --sidebar-border: #eaeaea;
        --sidebar-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        --chat-bg: #fff;
        --chat-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        --bubble-incoming: #f5f5f7;
        --bubble-outgoing: var(--primary-light);
        --bubble-incoming-color: #1a1a1a;
        /* Improved contrast */
        --bubble-outgoing-color: #fff;
        --unread-bg: #ff2d55;
        --unread-color: #fff;
        --border-radius: 24px;
        --avatar-bg: #e0e0e0;
        --input-bg: #f5f5f7;
        --input-radius: 18px;
        --input-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        --transition: all 0.2s ease;
    }

    body {
        background: #f8fafc;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        margin: 0;
    }

    .container {
        /* max-width: 1200px;
        margin: 40px auto;
        padding: 0 16px; */
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 30px;
    }

    .chat-container {
        display: flex;
        gap: 24px;
        min-height: 70vh;
        max-height: 90vh;
    }

    .sidebar-container {
    background: var(--sidebar-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--sidebar-shadow);
    padding: 24px 0 0 0;
    width: 340px;
    min-width: 280px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-height: 150px;
}

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 32px 8px 32px;
    }

    .sidebar-header h2 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .sidebar-header .sidebar-menu {
        font-size: 1.5rem;
        color: #444;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
        transition: var(--transition);
    }

    .sidebar-header .sidebar-menu:hover {
        color: var(--primary);
    }

    .sidebar-search {
        padding: 0 24px 16px 24px;
    }

    .sidebar-search input {
        width: 100%;
        padding: 12px 18px;
        border-radius: 24px;
        border: none;
        background: var(--input-bg);
        font-size: 1rem;
        box-shadow: var(--input-shadow);
        outline: none;
        transition: var(--transition);
    }

    .sidebar-search input:focus {
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .sidebar-people-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #222;
        padding: 0 24px 8px 24px;
        margin: 0 0 0.5rem 0;
    }

    .sidebar-users-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 0 8px 0;
        scroll-behavior: smooth;
    }

    .sidebar-user-item {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        cursor: pointer;
        transition: var(--transition);
        border-radius: 16px;
        margin: 0 8px 2px 8px;
        background: #fff;
        position: relative;
        z-index: 1;
    }

    .sidebar-user-item:hover,
    .sidebar-user-item.active {
        background: #f0f0ff;
        z-index: 2;
    }

    .sidebar-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 14px;
        border: 2px solid #f5f5f7;
        background: var(--avatar-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
    }

    .sidebar-user-avatar:empty::before {
        content: attr(alt);
        display: block;
    }

    .sidebar-user-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .sidebar-user-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-user-name {
        font-weight: 600;
        font-size: 1rem;
        color: #222;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    .sidebar-user-time {
        font-size: 0.9rem;
        color: #aaa;
        margin-left: 8px;
        white-space: nowrap;
    }

    .sidebar-user-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2px;
    }

    .sidebar-user-preview {
        font-size: 0.97rem;
        color: #888;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    .sidebar-user-badges {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .sidebar-user-unread {
        background: var(--unread-bg);
        color: var(--unread-color);
        border-radius: 50%;
        font-size: 0.85rem;
        font-weight: 600;
        min-width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 4px;
    }

    .sidebar-user-tick {
        color: var(--primary);
        font-size: 1.1rem;
        margin-left: 4px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .chat-screen {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-radius: var(--border-radius);
        background: var(--chat-bg);
        box-shadow: var(--chat-shadow);
        min-width: 0;
        overflow: hidden;
    }

    .chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 32px 16px 32px;
        background: var(--chat-bg);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .chat-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .chat-header-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        background: var(--avatar-bg);
        border: 2px solid #f5f5f7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
    }

    .chat-header-avatar:empty::before {
        content: attr(alt);
        display: block;
    }

    .chat-header-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .chat-header-username {
        font-size: 1.35rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 2px;
    }

    .chat-header-status {
        font-size: 1rem;
        color: #888;
        font-weight: 400;
    }

    .chat-header-right {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .chat-header-back-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: none;
        background: none;
        color: #666;
        cursor: pointer;
        border-radius: 50%;
        transition: var(--transition);
        font-size: 1.2rem;
    }

    .chat-header-back-btn:hover {
        background: #f5f5f7;
        color: var(--primary);
    }

    .chat-header-icon {
        font-size: 1.45rem;
        color: #bbb;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        transition: var(--transition);
    }

    .chat-header-icon:hover {
        color: var(--primary);
    }

    .chat-header-divider {
        border-bottom: 1px solid #eee;
        margin: 0 32px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 24px 32px;
        background: var(--chat-bg);
        display: flex;
        flex-direction: column;
        gap: 18px;
        scroll-behavior: smooth;
    }

    .chat-date-header {
        text-align: center;
        font-size: 0.9rem;
        font-weight: 500;
        color: #666;
        background: #f5f5f7;
        padding: 8px 16px;
        border-radius: 12px;
        margin: 12px auto;
        display: inline-block;
        box-shadow: var(--input-shadow);
    }

    .chat-message-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-bubble {
        max-width: 60%;
        padding: 16px 22px;
        border-radius: 22px 22px 22px 6px;
        font-size: 1.08rem;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        position: relative;
        display: inline-block;
        animation: slideIn 0.3s ease-out;
    }

    .chat-bubble-incoming {
        background: var(--bubble-incoming);
        color: var(--bubble-incoming-color);
        align-self: flex-start;
        border-radius: 22px 22px 6px 22px;
    }

    .chat-bubble-outgoing {
        background: var(--bubble-outgoing);
        color: var(--bubble-outgoing-color);
        align-self: flex-end;
        border-radius: 22px 22px 22px 6px;
    }

    .chat-bubble-timestamp {
        font-size: 0.85rem;
        color: #aaa;
        margin-top: 4px;
        display: block;
        text-align: right;
    }

    .chat-bubble-incoming+.chat-bubble-timestamp {
        text-align: left;
    }

    .message-input-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 32px;
        background: var(--input-bg);
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        box-shadow: var(--input-shadow);
    }

    .input-attach-icon,
    .input-action-icon {
        font-size: 1.4rem;
        color: #bbb;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        transition: var(--transition);
    }

    .input-attach-icon:hover,
    .input-action-icon:hover {
        color: var(--primary);
    }

    .input-text {
        flex: 1;
        padding: 14px 18px;
        border: none;
        border-radius: var(--input-radius);
        font-size: 1.08rem;
        background: #fff;
        outline: none;
        margin: 0 8px;
        box-shadow: var(--input-shadow);
        transition: var(--transition);
    }

    .input-text:focus {
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .no-chat {
        padding: 60px 0;
        text-align: center;
        color: #aaa;
        font-size: 1.2rem;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 900px) {
        .container {
            padding: 0 8px;
            margin: 20px auto;
        }

        .chat-container {
            flex-direction: column;
            gap: 16px;
            min-height: auto;
        }

        .sidebar-container,
        .chat-screen {
            width: 100%;
            min-width: 0;
            margin: 0 0 16px 0;
            max-height: none;
            border-radius: var(--border-radius);
        }

        .chat-header,
        .chat-messages,
        .message-input-bar {
            padding-left: 16px;
            padding-right: 16px;
        }
    }

    @media (max-width: 600px) {
        .sidebar-container {
            padding-top: 16px;
        }
        

        .sidebar-header h2 {
            font-size: 1.2rem;
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
        }

        .chat-header-avatar {
            width: 48px;
            height: 48px;
        }

        .chat-header-username {
            font-size: 1.2rem;
        }

        .chat-bubble {
            max-width: 75%;
            font-size: 1rem;
        }

        .input-text {
            font-size: 1rem;
            width: 1rem;
        }

        .chat-date-header {
            font-size: 0.8rem;
            padding: 6px 12px;
        }

        .chat-header-back-btn {
            display: flex;
        }
    }
</style>

<?php if(isset($_GET['other'])):  ?>
<style>
        @media (max-width: 600px) {

    .sidebar-container {
        display: none;
    }
}
</style>
<?php endif; ?>



<div class="container">
    <div class="chat-container gap-3">
        <!-- Left Sidebar for Users -->
        <?= $this->render('_side_bar', ['peoples' => $peoples, 'other' => isset($other) ? $other : null]); ?>

        <!-- Right Chat Screen -->
         <?php if(isset($_GET['other'])): ?>
        <?= $this->render('_chat_screen', ['other' => isset($other) ? $other : null]); ?>
            <?php else: ?>
        <?= $this->render('_Inbox_screen'); ?>
        <?php endif; ?>
    </div>
</div>
<?php if(!isset($_GET['other'])): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<script>
    function decryptText(encryptedText, secretKey) {
        let bytes = CryptoJS.AES.decrypt(encryptedText, secretKey);
        return bytes.toString(CryptoJS.enc.Utf8);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const secretKey = "random1000secret1000keys";
        document.querySelectorAll('.sidebar-last-message').forEach(function(el) {
            try {
                const decrypted = decryptText(el.textContent.trim(), secretKey);
                if (decrypted) {
                    el.textContent = decrypted;
                }
            } catch (e) {
                console.error('Failed to decrypt preview:', e);
            }
        });
    });
</script>
<?php else: ?>

<!-- //////Mesage chat section script//// -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        const secretkeyForEncryption = "random1000secret1000keys";

        function encryptText(text, secretKey) {
            return CryptoJS.AES.encrypt(text, secretKey).toString();
        }

        function decryptText(encryptedText, secretKey) {
            let bytes = CryptoJS.AES.decrypt(encryptedText, secretKey);
            return bytes.toString(CryptoJS.enc.Utf8);
        }



        const baseUrl = "<?php echo Helper::baseUrl('') ?>";
        const myId = "<?php echo Yii::$app->user->identity->id; ?>";
        const myName = "<?php echo Yii::$app->user->identity->username; ?>";
        const otherId = "<?php echo Helper::getuseridfromslug(Yii::$app->request->get('other')); ?>";

        

        function formatDateForHeader(date) {
            const today = new Date();
            const messageDate = new Date(date);
            const isToday = messageDate.toDateString() === today.toDateString();
            if (isToday) return "Today";
            const options = {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            };
            return messageDate.toLocaleDateString('en-US', options);
        }

        function formatTimeForDisplay(date) {
            const messageDate = new Date(date);
            return messageDate.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
        }

        function addMessage(data) {
            const messagesDiv = document.getElementById('chatMessages');
            const isIncoming = data.sender_id == otherId;
            const bubbleClass = isIncoming ? 'chat-bubble chat-bubble-incoming' : 'chat-bubble chat-bubble-outgoing';
            const messageDate = new Date(data.created_at).toDateString();
            const lastDate = messagesDiv.dataset.lastDate || '';
            const dateHeader = formatDateForHeader(data.created_at);

            if (messageDate !== lastDate) {
                messagesDiv.insertAdjacentHTML('beforeend', `
                    <div class="chat-date-header">${dateHeader}</div>
                    <div class="chat-message-group" data-date="${messageDate}"></div>
                `);
                messagesDiv.dataset.lastDate = messageDate;
            }

            const groupDiv = messagesDiv.querySelector(`.chat-message-group[data-date="${messageDate}"]`);
            groupDiv.insertAdjacentHTML('beforeend', `
                <div class="${bubbleClass}">
                    <div>${decryptText(data.message, secretkeyForEncryption)}</div>
                </div>
                <span class="chat-bubble-timestamp">${formatTimeForDisplay(data.created_at)}</span>
            `);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function SSE_EVENT() {
            const eventSource = new EventSource(`${baseUrl}sse/chat?myId=${myId}&otherId=${otherId}`);
            eventSource.onmessage = function(event) {
                const data = JSON.parse(event.data);
                addMessage(data);
            };
            eventSource.onerror = function(event) {
                // console.error("Error occurred:", event);
            };
        }
        SSE_EVENT();

        async function sendMessage(senderId, receiverId, message, job_post_id) {
            const response = await fetch(`${baseUrl}api/add-message`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    job_post_id: job_post_id,
                    sender_id: senderId,
                    receiver_id: receiverId,
                    message: message,
                }),
            });
            const result = await response.json();
            if (result.success) {
                console.log('Message sent:', result.data);
            } else {
                console.error('Error:', result.message, result.errors);
            }
        }

        function showMessages() {
            fetch(`${baseUrl}api/messages?other=${otherId}`)
                .then(r => r.json())
                .then(d => {
                    const messages = d.messages;
                    const messagesDiv = document.getElementById('chatMessages');
                    messagesDiv.innerHTML = '';
                    let lastDate = '';
                    messages.forEach(data => {
                        const isIncoming = data.message.sender_id == otherId;
                        const bubbleClass = isIncoming ? 'chat-bubble chat-bubble-incoming' : 'chat-bubble chat-bubble-outgoing';
                        const messageDate = new Date(data.message.created_at).toDateString();
                        const dateHeader = formatDateForHeader(data.message.created_at);

                        if (messageDate !== lastDate) {
                            messagesDiv.insertAdjacentHTML('beforeend', `
                                <div class="chat-date-header">${dateHeader}</div>
                                <div class="chat-message-group" data-date="${messageDate}"></div>
                            `);
                            lastDate = messageDate;
                        }

                        const groupDiv = messagesDiv.querySelector(`.chat-message-group[data-date="${messageDate}"]`);
                        groupDiv.insertAdjacentHTML('beforeend', `
                            <div class="${bubbleClass}">
                                <div>${decryptText(data.message.message, secretkeyForEncryption)}</div>
                            </div>
                            <span class="chat-bubble-timestamp">${formatTimeForDisplay(data.message.created_at)}</span>
                        `);
                    });
                    messagesDiv.dataset.lastDate = lastDate;
                    scrollChatToBottom(); // Scroll to bottom after loading messages
                });
        }
        showMessages();

        function getFormatedTime() {
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const day = String(currentDate.getDate()).padStart(2, '0');
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            const seconds = String(currentDate.getSeconds()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        const postID = "<?php echo Yii::$app->request->get('post'); ?>";
        if (parseInt(postID) > 0) {
            const postTitle = "I am interested for : <?php echo $post->title ?? ''; ?>";
            const encText = encryptText(postTitle, secretkeyForEncryption);
            const data = {
                job_post_id: postID,
                sender_id: myId,
                sender: myName,
                created_at: getFormatedTime(),
                message: encText,
            };
            sendMessage(myId, otherId, encText, postID);
            showMessages();
            removeURLParameter('post');
        }

        function removeURLParameter(parameter) {
            let url = new URL(window.location.href);
            url.searchParams.delete(parameter);
            window.history.replaceState(null, null, url.toString());
        }

        const messagForm = document.querySelector("#messageForm");
        if (messagForm) {
            messagForm.addEventListener("submit", (event) => {
                event.preventDefault();
                const messageInput = document.querySelector("#messageText");
                if (messageInput.value.length > 0) {
                    const encText = encryptText(messageInput.value, secretkeyForEncryption);
                    const data = {
                        job_post_id: null,
                        sender_id: myId,
                        sender: myName,
                        created_at: getFormatedTime(),
                        message: encText,
                    };
                    addMessage(data);
                    sendMessage(myId, otherId, encText, 0);
                    messagForm.reset();
                    sendBtn.classList.remove('active');
                }
            });
            const messageInput = document.querySelector("#messageText");
            const sendBtn = messagForm.querySelector(".input-action-icon");
            if (messageInput && sendBtn) {
                messageInput.addEventListener('input', function() {
                    if (messageInput.value.trim().length > 0) {
                        sendBtn.classList.add('active');
                    } else {
                        sendBtn.classList.remove('active');
                    }
                });
            }
        }

        // --- Add search functionality for contacts ---
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('sidebarSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = searchInput.value.trim().toLowerCase();
                    document.querySelectorAll('.sidebar-user-item').forEach(function(item) {
                        const nameSpan = item.querySelector('.sidebar-user-name');
                        if (!nameSpan) return;
                        const name = nameSpan.textContent.trim().toLowerCase();
                        if (name.includes(filter)) {
                            item.parentElement.style.display = '';
                        } else {
                            item.parentElement.style.display = 'none';
                        }
                    });
                });
            }
        });

        function scrollChatToBottom() {
            const messagesDiv = document.getElementById('chatMessages');
            if (messagesDiv) {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        }

        // Also scroll to bottom on initial page load (in case messages are already present)
        document.addEventListener('DOMContentLoaded', function() {
            scrollChatToBottom();

            document.body.scrollTop = document.body.scrollHeight;
        });

        // Function to go back to people list
        function goBack() {
            // Remove the 'other' parameter from URL to go back to people list
            const url = new URL(window.location.href);
            url.searchParams.delete('other');
            window.location.href = url.toString();
        }
    </script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const secretKey = "random1000secret1000keys";
    document.querySelectorAll('.sidebar-last-message').forEach(function(el) {
        try {
            const decrypted = decryptText(el.textContent.trim(), secretKey);
            if (decrypted) {
                el.textContent = decrypted;
            }
        } catch (e) {
            console.error('Failed to decrypt preview:', e);
        }
    });
});
</script>
<?php endif; ?>