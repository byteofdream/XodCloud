<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <div class="profile-header modern" style="background-image: url('<?php echo $profileUser['banner'] ?? '/assets/img/banner-default.svg'; ?>')">
            <img src="<?php echo $profileUser['avatar']; ?>" class="avatar large" alt="avatar">
            <div>
                <h1><?php echo htmlspecialchars($profileUser['display_name'] ?? $profileUser['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="profile-username">@<?php echo htmlspecialchars($profileUser['username'], ENT_QUOTES, 'UTF-8'); ?></div>
                <p><?php echo nl2br(htmlspecialchars($profileUser['bio'], ENT_QUOTES, 'UTF-8')); ?></p>
                <div class="profile-actions">
                    <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$profileUser['id']): ?>
                        <form class="inline" action="/follow.php" method="post">
                            <input type="hidden" name="user_id" value="<?php echo (int)$profileUser['id']; ?>">
                            <button type="submit" class="play-btn"><?php echo $isFollowing ? 'Following' : 'Follow'; ?></button>
                        </form>
                        <button class="ghost-btn message-toggle" data-target="message-form">Message</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile-stats">
                <div>
                    <strong><?php echo count($tracks); ?></strong>
                    <span>Tracks</span>
                </div>
                <div>
                    <strong><?php echo (int)$followersCount; ?></strong>
                    <span>Followers</span>
                </div>
                <div>
                    <strong><?php echo (int)$followingCount; ?></strong>
                    <span>Following</span>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$profileUser['id']): ?>
            <form id="message-form" class="message-form hidden" action="/message-send.php" method="post">
                <input type="hidden" name="receiver_id" value="<?php echo (int)$profileUser['id']; ?>">
                <textarea name="body" rows="3" placeholder="Write a message"></textarea>
                <button type="submit">Send message</button>
            </form>
        <?php endif; ?>

        <div class="profile-tracks">
            <div class="feed-tabs">
                <span class="tab active">Tracks</span>
                <span class="tab">Playlists</span>
                <span class="tab">Reposts</span>
            </div>
            <?php foreach ($tracks as $track): ?>
                <article class="track-row modern">
                    <div class="track-row-cover" style="background-image: url('<?php echo $track['cover_path']; ?>')"></div>
                    <div class="track-row-info">
                        <a href="/track.php?id=<?php echo (int)$track['id']; ?>" class="title">
                            <?php echo htmlspecialchars($track['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <div class="waveform" data-audio="<?php echo $track['audio_path']; ?>"></div>
                    </div>
                    <button class="play-btn" data-audio="<?php echo $track['audio_path']; ?>">Play</button>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <aside class="right-rail modern">
        <h3>Top picks</h3>
        <div class="related-list">
            <?php foreach ($tracks as $track): ?>
                <a class="related-item" href="/track.php?id=<?php echo (int)$track['id']; ?>">
                    <div class="thumb" style="background-image: url('<?php echo $track['cover_path']; ?>')"></div>
                    <div>
                        <div class="title"><?php echo htmlspecialchars($track['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="artist"><?php echo htmlspecialchars($track['username'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>
</section>

