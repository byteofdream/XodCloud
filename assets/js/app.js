const waves = new Map();
let currentWave = null;
let currentButton = null;

function buildWaveform(el) {
    const audio = el.dataset.audio;
    if (!audio || waves.has(el)) return;

    const wave = WaveSurfer.create({
        container: el,
        waveColor: '#d1d1d1',
        progressColor: '#ff5500',
        cursorColor: '#ff5500',
        barWidth: 2,
        barGap: 2,
        height: el.classList.contains('large') ? 160 : 70,
        normalize: true,
    });
    wave.load(audio);
    waves.set(el, wave);
}

function pauseAll(exceptWave) {
    waves.forEach((wave) => {
        if (wave !== exceptWave && wave.isPlaying()) {
            wave.pause();
        }
    });
}

function updateMiniPlayer(title, artist, isPlaying) {
    const mini = document.getElementById('mini-player');
    if (!mini) return;
    mini.querySelector('.mini-title').textContent = title || 'Nothing playing';
    mini.querySelector('.mini-artist').textContent = artist || '-';
    const btn = document.getElementById('mini-play');
    if (btn) btn.textContent = isPlaying ? 'Pause' : 'Play';
}

function getTrackMeta(btn) {
    const card = btn.closest('.track-card') || btn.closest('.track-hero-left') || btn.closest('.track-row');
    if (!card) return { title: 'Track', artist: 'Artist' };
    const title = card.querySelector('.title')?.textContent || card.querySelector('h1')?.textContent || 'Track';
    const artist = card.querySelector('.artist')?.textContent || card.querySelector('.track-by a')?.textContent || 'Artist';
    return { title: title.trim(), artist: artist.trim() };
}

function setup() {
    document.querySelectorAll('.waveform').forEach(buildWaveform);

    document.querySelectorAll('.play-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const audio = btn.dataset.audio;
            const wf = [...waves.entries()].find(([el]) => el.dataset.audio === audio)?.[1];

            if (!wf) return;

            if (wf.isPlaying()) {
                wf.pause();
                btn.textContent = 'Play';
                currentWave = wf;
                currentButton = btn;
                updateMiniPlayer(getTrackMeta(btn).title, getTrackMeta(btn).artist, false);
            } else {
                pauseAll(wf);
                wf.play();
                btn.textContent = 'Pause';
                currentWave = wf;
                currentButton = btn;
                const meta = getTrackMeta(btn);
                updateMiniPlayer(meta.title, meta.artist, true);
                wf.on('finish', () => {
                    btn.textContent = 'Play';
                    updateMiniPlayer(meta.title, meta.artist, false);
                });
            }
        });
    });

    const miniPlay = document.getElementById('mini-play');
    if (miniPlay) {
        miniPlay.addEventListener('click', () => {
            if (!currentWave) return;
            if (currentWave.isPlaying()) {
                currentWave.pause();
                if (currentButton) currentButton.textContent = 'Play';
                updateMiniPlayer(getTrackMeta(currentButton).title, getTrackMeta(currentButton).artist, false);
            } else {
                currentWave.play();
                if (currentButton) currentButton.textContent = 'Pause';
                updateMiniPlayer(getTrackMeta(currentButton).title, getTrackMeta(currentButton).artist, true);
            }
        });
    }

    document.querySelectorAll('.share-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const link = window.location.origin + btn.dataset.share;
            navigator.clipboard.writeText(link).then(() => {
                btn.textContent = 'Copied';
                setTimeout(() => {
                    btn.textContent = 'Share';
                }, 1200);
            });
        });
    });

    document.querySelectorAll('.message-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            const form = document.getElementById(targetId);
            if (form) {
                form.classList.toggle('hidden');
            }
        });
    });
}

window.addEventListener('load', setup);
