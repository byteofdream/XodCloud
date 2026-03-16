-- SQLite schema + sample data for XodCloud
PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS follows;
DROP TABLE IF EXISTS reactions;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS tracks;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    display_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    avatar TEXT NOT NULL,
    banner TEXT NOT NULL,
    bio TEXT,
    created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE tracks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    audio_path TEXT NOT NULL,
    cover_path TEXT NOT NULL,
    duration TEXT DEFAULT '3:00',
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    track_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    body TEXT NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE reactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    track_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    type TEXT NOT NULL CHECK (type IN ('like', 'repost')),
    created_at TEXT DEFAULT (datetime('now')),
    UNIQUE (track_id, user_id, type),
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE follows (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    follower_id INTEGER NOT NULL,
    following_id INTEGER NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    UNIQUE (follower_id, following_id),
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sender_id INTEGER NOT NULL,
    receiver_id INTEGER NOT NULL,
    body TEXT NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, display_name, email, password_hash, avatar, banner, bio) VALUES
('echo_day', 'Echo Day', 'echo@example.com', '$2y$12$5HE8NNxHO8IJT9sRw1oslOU1QI/jyAQQKdysbCN/TrEezLvUOAcxi', '/assets/img/default-avatar.svg', '/assets/img/banner-default.svg', 'Ambient sketches and slow sunrise loops.'),
('nightline', 'Nightline', 'night@example.com', '$2y$12$5HE8NNxHO8IJT9sRw1oslOU1QI/jyAQQKdysbCN/TrEezLvUOAcxi', '/assets/img/default-avatar.svg', '/assets/img/banner-default.svg', 'Late-night club edits and synth pulses.');

INSERT INTO tracks (user_id, title, description, audio_path, cover_path, duration) VALUES
(1, 'Morning Signal', 'Tape-hiss textures and soft pads.', '/uploads/demo-1.mp3', '/assets/img/cover-default.svg', '3:42'),
(2, 'Neon Drift', 'Driving bass with a classic 2020 wave.', '/uploads/demo-2.mp3', '/assets/img/cover-default.svg', '4:08');

INSERT INTO comments (track_id, user_id, body) VALUES
(1, 2, 'Love the texture on this. Feels like foggy sunrise.'),
(2, 1, 'That bassline is massive.');

INSERT INTO reactions (track_id, user_id, type) VALUES
(1, 2, 'like'),
(2, 1, 'like'),
(2, 1, 'repost');

INSERT INTO follows (follower_id, following_id) VALUES
(1, 2);

INSERT INTO messages (sender_id, receiver_id, body) VALUES
(2, 1, 'Hey! Loved your last upload. Want to collab?');
