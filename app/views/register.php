<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <section class="auth modern">
            <h1>Create your account</h1>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <form class="auth-form" method="post" action="/register.php">
                <label>
                    Username
                    <input type="text" name="username" required>
                </label>
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
                <label>
                    Password
                    <input type="password" name="password" required>
                </label>
                <button type="submit">Create account</button>
            </form>
        </section>
    </div>
    <aside class="right-rail modern">
        <h3>Already have an account?</h3>
        <p class="muted">Login to access your stream and library.</p>
        <a class="ghost-btn" href="/login.php">Login</a>
    </aside>
</section>
