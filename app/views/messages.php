<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <div class="messages">
            <div class="feed-head">
                <h1 class="page-title">Messages</h1>
                <div class="feed-tabs">
                    <span class="tab active">Inbox</span>
                    <span class="tab">Sent</span>
                </div>
            </div>
            <?php if (empty($messages)): ?>
                <p class="muted">No messages yet.</p>
            <?php else: ?>
                <div class="message-list">
                    <?php foreach ($messages as $message): ?>
                        <div class="message-item">
                            <img src="<?php echo $message['avatar']; ?>" class="avatar" alt="avatar">
                            <div>
                                <div class="message-head">
                                    <strong><?php echo htmlspecialchars($message['username'], ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <span><?php echo htmlspecialchars($message['created_at'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <p><?php echo nl2br(htmlspecialchars($message['body'], ENT_QUOTES, 'UTF-8')); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <aside class="right-rail modern">
        <h3>Quick actions</h3>
        <div class="related-list">
            <a class="related-item" href="/upload.php">
                <div class="thumb" style="background-image: url('/assets/img/cover-default.svg')"></div>
                <div>
                    <div class="title">Upload a track</div>
                    <div class="artist">Share your latest</div>
                </div>
            </a>
        </div>
    </aside>
</section>
