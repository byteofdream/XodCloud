<?php
$config = require __DIR__ . '/../../../config/config.php';
$baseUrl = $config['base_url'];
$searchTerm = htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XodCloud</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="site-header modern">
    <div class="header-inner">
        <a class="logo" href="/index.php" aria-label="XodCloud">
            <span class="logo-mark">X</span>
            <span class="logo-text">xodcloud</span>
        </a>
        <form class="search-bar" action="/search.php" method="get">
            <input type="text" name="q" placeholder="Search for artists, tracks, podcasts" value="<?php echo $searchTerm; ?>">
            <button type="submit">Search</button>
        </form>
        <nav class="nav-links">
            <a href="/upload.php">Upload</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/messages.php">Messages</a>
                <a href="/profile.php?id=<?php echo (int)$_SESSION['user_id']; ?>">Profile</a>
                <a href="/settings.php">Settings</a>
            <?php else: ?>
                <a href="/login.php">Login</a>
                <a href="/register.php" class="btn-accent">Create account</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="main-content modern">
