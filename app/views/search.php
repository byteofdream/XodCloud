<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <h1 class="page-title">Search results</h1>
        <?php if ($term === ''): ?>
            <p class="muted">Try searching for a track or artist.</p>
        <?php else: ?>
            <p class="muted">Showing results for "<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"</p>
            <div class="feed-grid">
                <?php foreach ($results as $track): ?>
                    <article class="track-card modern">
                        <div class="track-cover" style="background-image: url('<?php echo $track['cover_path']; ?>')"></div>
                        <div class="track-info">
                            <div class="track-meta">
                                <a class="artist" href="/profile.php?id=<?php echo (int)$track['user_id']; ?>">
                                    <?php echo htmlspecialchars($track['username'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                                <a class="title" href="/track.php?id=<?php echo (int)$track['id']; ?>">
                                    <?php echo htmlspecialchars($track['title'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </div>
                            <div class="waveform" data-audio="<?php echo $track['audio_path']; ?>"></div>
                            <div class="track-actions">
                                <button class="play-btn" data-audio="<?php echo $track['audio_path']; ?>">Play</button>
                                <form class="inline" action="/track-react.php" method="post">
                                    <input type="hidden" name="track_id" value="<?php echo (int)$track['id']; ?>">
                                    <input type="hidden" name="type" value="like">
                                    <button type="submit" class="ghost-btn">Like (<?php echo (int)$track['likes_count']; ?>)</button>
                                </form>
                                <form class="inline" action="/track-react.php" method="post">
                                    <input type="hidden" name="track_id" value="<?php echo (int)$track['id']; ?>">
                                    <input type="hidden" name="type" value="repost">
                                    <button type="submit" class="ghost-btn">Repost (<?php echo (int)$track['reposts_count']; ?>)</button>
                                </form>
                                <button class="ghost-btn share-btn" data-share="/track.php?id=<?php echo (int)$track['id']; ?>">Share</button>
                                <a class="ghost-btn" href="/track.php?id=<?php echo (int)$track['id']; ?>#comments">Comment</a>
                                <span class="duration"><?php echo htmlspecialchars($track['duration'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <aside class="right-rail modern">
        <h3>Recommended</h3>
        <div class="related-list">
            <?php foreach ($results as $track): ?>
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
