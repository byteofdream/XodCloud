<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel track-page modern">
        <div class="track-hero modern">
            <div class="track-hero-left">
                <div class="track-hero-meta">
                    <div class="track-by">
                        <img src="<?php echo $track['avatar']; ?>" alt="avatar" class="avatar">
                        <a href="/profile.php?id=<?php echo (int)$track['user_id']; ?>">
                            <?php echo htmlspecialchars($track['username'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </div>
                    <h1><?php echo htmlspecialchars($track['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                </div>
                <div class="waveform large" data-audio="<?php echo $track['audio_path']; ?>"></div>
                <div class="track-actions">
                    <button class="play-btn" data-audio="<?php echo $track['audio_path']; ?>">Play</button>
                    <form class="inline" action="/track-react.php" method="post">
                        <input type="hidden" name="track_id" value="<?php echo (int)$track['id']; ?>">
                        <input type="hidden" name="type" value="like">
                        <button type="submit" class="ghost-btn">Like (<?php echo (int)$likes; ?>)</button>
                    </form>
                    <form class="inline" action="/track-react.php" method="post">
                        <input type="hidden" name="track_id" value="<?php echo (int)$track['id']; ?>">
                        <input type="hidden" name="type" value="repost">
                        <button type="submit" class="ghost-btn">Repost (<?php echo (int)$reposts; ?>)</button>
                    </form>
                    <button class="ghost-btn share-btn" data-share="/track.php?id=<?php echo (int)$track['id']; ?>">Share</button>
                    <a class="ghost-btn" href="#comments">Comment</a>
                </div>
                <p class="track-desc"><?php echo nl2br(htmlspecialchars($track['description'], ENT_QUOTES, 'UTF-8')); ?></p>
            </div>
            <div class="track-hero-right" style="background-image: url('<?php echo $track['cover_path']; ?>')"></div>
        </div>

        <div id="comments" class="comments">
            <h2>Comments</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="/track-comment.php" method="post">
                    <input type="hidden" name="track_id" value="<?php echo (int)$track['id']; ?>">
                    <textarea name="body" placeholder="Write a comment"></textarea>
                    <button type="submit">Post comment</button>
                </form>
            <?php else: ?>
                <p class="muted">Login to comment.</p>
            <?php endif; ?>

            <div class="comment-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <img src="<?php echo $comment['avatar']; ?>" alt="avatar" class="avatar">
                        <div>
                            <strong><?php echo htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <p><?php echo nl2br(htmlspecialchars($comment['body'], ENT_QUOTES, 'UTF-8')); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <aside class="right-rail modern">
        <h3>Related tracks</h3>
        <div class="related-list">
            <?php foreach ($related as $item): ?>
                <a class="related-item" href="/track.php?id=<?php echo (int)$item['id']; ?>">
                    <div class="thumb" style="background-image: url('<?php echo $item['cover_path']; ?>')"></div>
                    <div>
                        <div class="title"><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <div class="artist"><?php echo htmlspecialchars($item['username'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>
</section>
