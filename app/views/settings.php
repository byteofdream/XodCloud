<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings · XodCloud</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="settings-body">
    <main class="settings-page">
        <div class="settings-header">
            <div>
                <h1>Account settings</h1>
                <p>Customize your profile details, avatar, and banner. Changes are live instantly.</p>
            </div>
            <a class="ghost-btn" href="/profile.php?id=<?php echo (int)$user['id']; ?>">Back to profile</a>
        </div>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form class="settings-form" action="/settings.php" method="post" enctype="multipart/form-data">
            <div class="settings-grid">
                <label class="form-field">
                    <span class="label-text">Display name</span>
                    <input type="text" name="display_name" value="<?php echo htmlspecialchars($user['display_name'] ?? $user['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <span class="helper-text">This is what listeners see.</span>
                </label>
                <label class="form-field">
                    <span class="label-text">Username</span>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <span class="helper-text">Used in your profile URL.</span>
                </label>
            </div>

            <label class="form-field">
                <span class="label-text">Bio</span>
                <textarea name="bio" rows="4"><?php echo htmlspecialchars($user['bio'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                <span class="helper-text">Tell listeners who you are.</span>
            </label>

            <div class="settings-grid">
                <label class="form-field">
                    <span class="label-text">Avatar</span>
                    <input type="file" name="avatar" accept="image/png,image/jpeg,image/webp">
                    <span class="helper-text">Square image recommended.</span>
                </label>
                <label class="form-field">
                    <span class="label-text">Banner</span>
                    <input type="file" name="banner" accept="image/png,image/jpeg,image/webp">
                    <span class="helper-text">Wide image works best (1600×400).</span>
                </label>
            </div>

            <div class="settings-actions">
                <button type="submit">Save changes</button>
                <a class="ghost-btn" href="/logout.php">Log out</a>
            </div>
        </form>
    </main>
</body>
</html>
