<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <section class="auth modern">
            <h1>Welcome back</h1>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form class="auth-form" method="post" action="/login.php">
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
                <label>
                    Password
                    <input type="password" name="password" required>
                </label>
                <button type="submit">Login</button>
            </form>
        </section>
    </div>
    <aside class="right-rail modern">
        <h3>New to XodCloud?</h3>
        <p class="muted">Create an account to follow artists, like tracks, and build your library.</p>
        <a class="ghost-btn" href="/register.php">Create account</a>
    </aside>
</section>
