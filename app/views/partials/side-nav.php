<?php
$navItems = [
    ['label' => 'Home', 'href' => '/index.php'],
    ['label' => 'Stream', 'href' => '/stream.php'],
    ['label' => 'Library', 'href' => '/library.php'],
    ['label' => 'Upload', 'href' => '/upload.php'],
    ['label' => 'Messages', 'href' => '/messages.php'],
];
?>
<nav class="side-nav">
    <div class="side-section">
        <?php foreach ($navItems as $item): ?>
            <a class="side-link" href="<?php echo $item['href']; ?>">
                <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="side-section">
        <span class="side-title">Your likes</span>
        <a class="side-link muted" href="/library.php">Recently liked</a>
        <a class="side-link muted" href="/library.php">Playlists</a>
    </div>
</nav>
