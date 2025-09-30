<?php 
use app\components\Helper;

 ?>
<div class="col-md-4 sidebar-container">
            <div class="sidebar-header">
                <h2>Messages</h2>
                <button class="sidebar-menu"><i class="fa fa-ellipsis-h"></i></button>
            </div>
            <?php /*?>
            <div class="sidebar-search">
                <input type="text" placeholder="Search">
            </div>
            <?php */?>

            <!-- <div class="sidebar-people-title">People</div> -->
            <div class="sidebar-users-list">
                <?php //print_r($peoples)
                ?>
                <?php foreach ($peoples as $people):
                    $profileImg = isset($people['avatar']) ? $people['avatar'] : Helper::baseUrl('custom/images/avatars/avatar-1.png');
                    $preview = isset($people['last_msg']) ? $people['last_msg'] : 'Messagettt preview...';

                    $time = isset($people['last_time']) ? yii::$app->formatter->asRelativeTime($people['last_time']) : '';
                    //$unread = isset($people['unread']) ? $people['unread'] : rand(0, 5);
                    $isActive = (isset($other) && $other->id == $people['id']);
                    $isRead = (isset($people['unread_count'])) ? $people['unread_count'] : false;

                ?>
                <a href="javascript:void(0);"  class="open-chat" data-userid="<?= $people['user_slug'] ?>" style="text-decoration:none;">
                    <?php /*?><a href="<?php echo Helper::baseUrl("/peoples/chat?other={$people['id']}") ?>" style="text-decoration:none;"><?php */?>
                        <div class="sidebar-user-item<?= $isActive ? ' active' : '' ?>">
                            <img class="sidebar-user-avatar" src="<?= htmlspecialchars($profileImg) ?>" alt="<?= htmlspecialchars($people['username'][0] ?? 'U') ?>">
                            <div class="sidebar-user-info">
                                <div class="sidebar-user-top">
                                    <span class="sidebar-user-name"><?= htmlspecialchars($people['username']); ?></span>
                                    <span class="sidebar-user-time"><?= htmlspecialchars($time); ?></span>
                                </div>
                                <div class="sidebar-user-bottom">
                                    <span class="sidebar-user-preview sidebar-last-message"><?= htmlspecialchars($preview); ?></span>
                                    <span class="sidebar-user-badges">
                                        <?php if ($isActive): ?>
                                            <i class="fa fa-check-double sidebar-user-tick"></i>
                                        <?php endif; ?>
                                        <?php if ($isRead > 0): ?>
                                            <span class="sidebar-user-unread"><?= $isRead ?></span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
$(document).on("click", ".open-chat", function () {
    let userId = $(this).data("userid");
    <?php $url=Helper::baseUrl(); ?>

    $.get("<?= $url ?>/chat/check-conversation", { otherId: userId }, function (res) {
        if (res.allowed) {
            window.location.href = res.chatUrl;
        } else {
            // Build apply URL with coins + redirect back to chat after payment
            let encodedChatUrl = encodeURIComponent(res.chatUrl);
            let applyUrl = "<?= Helper::baseUrl() ?>/tutor/apply-now?coins=" + res.coinsRequired +
                           "&url=" + encodedChatUrl;

            Swal.fire({
                title: "Unlock Chat?",
                text: "You need " + res.coinsRequired + " coins to start this conversation.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Pay & Unlock",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = applyUrl;
                }
            });
        }
    });
});


        </script>