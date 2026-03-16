<?php
require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare('INSERT INTO users (username, display_name, email, password_hash, avatar, banner, bio) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['username'],
            $data['display_name'],
            $data['email'],
            $data['password_hash'],
            $data['avatar'],
            $data['banner'],
            $data['bio']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function updateSettings(int $id, array $data): void {
        $stmt = $this->db->prepare('UPDATE users SET username = ?, display_name = ?, bio = ?, avatar = ?, banner = ? WHERE id = ?');
        $stmt->execute([
            $data['username'],
            $data['display_name'],
            $data['bio'],
            $data['avatar'],
            $data['banner'],
            $id
        ]);
    }
}
