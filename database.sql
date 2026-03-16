-- Database schema + sample data for Cloudwave
CREATE DATABASE IF NOT EXISTS soundcloud_clone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE soundcloud_clone;

DROP TABLE IF EXISTS reactions;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS tracks;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(60) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NOT NULL,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tracks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(120) NOT NULL,
    description TEXT,
    audio_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255) NOT NULL,
    duration VARCHAR(10) DEFAULT '3:00',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    track_id INT NOT NULL,
    user_id INT NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    track_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('like', 'repost') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_reaction (track_id, user_id, type),
    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, email, password_hash, avatar, bio) VALUES
('echo_day', 'echo@example.com', '$2y$12$5HE8NNxHO8IJT9sRw1oslOU1QI/jyAQQKdysbCN/TrEezLvUOAcxi', '/assets/img/default-avatar.svg', 'Ambient sketches and slow sunrise loops.'),
('nightline', 'night@example.com', '$2y$12$5HE8NNxHO8IJT9sRw1oslOU1QI/jyAQQKdysbCN/TrEezLvUOAcxi', '/assets/img/default-avatar.svg', 'Late-night club edits and synth pulses.');

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
