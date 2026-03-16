<section class="layout modern">
    <aside class="left-rail">
        <?php require __DIR__ . '/partials/side-nav.php'; ?>
    </aside>
    <div class="main-panel">
        <section class="upload modern">
            <h1>Upload your track</h1>
            <p class="upload-intro">Share your next release with the XodCloud community. Clean tags, a short description, and a strong title help your track get discovered.</p>
            <?php if (isset($_GET['error'])): ?>
                <p class="error">Please provide a title and an MP3 file.</p>
            <?php endif; ?>

            <form class="upload-form" action="/upload-save.php" method="post" enctype="multipart/form-data">
                <label class="form-field">
                    <span class="label-text">Track title</span>
                    <input type="text" name="title" required>
                    <span class="helper-text">Keep it short, recognizable, and searchable.</span>
                </label>
                <label class="form-field">
                    <span class="label-text">Description</span>
                    <textarea name="description" rows="4"></textarea>
                    <span class="helper-text">Tell listeners the vibe, story, or inspiration.</span>
                </label>
                <label class="form-field">
                    <span class="label-text">Duration (mm:ss)</span>
                    <input type="text" name="duration" placeholder="3:24">
                    <span class="helper-text">Optional. Format: minutes:seconds.</span>
                </label>
                <label class="file-input form-field">
                    <span class="label-text">MP3 File</span>
                    <input type="file" name="audio" accept="audio/mpeg" required>
                    <span class="helper-text">Upload an MP3 file. We’ll generate the waveform.</span>
                </label>
                <button type="submit">Upload track</button>
            </form>
        </section>
    </div>
    <aside class="right-rail modern">
        <h3>Tips</h3>
        <p class="muted">Upload high quality MP3s and add a short description to help discovery.</p>
    </aside>
</section>
