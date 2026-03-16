<?php
require_once __DIR__ . '/../core/Model.php';

class Track extends Model {
    public function all(): array {
        $stmt = $this->db->query("SELECT t.*, u.username, u.avatar,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'like') AS likes_count,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'repost') AS reposts_count
            FROM tracks t JOIN users u ON u.id = t.user_id ORDER BY t.created_at DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT t.*, u.username, u.avatar, u.bio,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'like') AS likes_count,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'repost') AS reposts_count
            FROM tracks t JOIN users u ON u.id = t.user_id WHERE t.id = ?");
        $stmt->execute([$id]);
        $track = $stmt->fetch();
        return $track ?: null;
    }

    public function findByUser(int $userId): array {
        $stmt = $this->db->prepare('SELECT * FROM tracks WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function search(string $term): array {
        $stmt = $this->db->prepare("SELECT t.*, u.username, u.avatar,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'like') AS likes_count,
            (SELECT COUNT(*) FROM reactions r WHERE r.track_id = t.id AND r.type = 'repost') AS reposts_count
            FROM tracks t JOIN users u ON u.id = t.user_id WHERE t.title LIKE ? ORDER BY t.created_at DESC");
        $stmt->execute(['%' . $term . '%']);
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare('INSERT INTO tracks (user_id, title, description, audio_path, cover_path, duration) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['audio_path'],
            $data['cover_path'],
            $data['duration']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function related(int $trackId, int $limit = 6): array {
        $stmt = $this->db->prepare('SELECT t.*, u.username, u.avatar FROM tracks t JOIN users u ON u.id = t.user_id WHERE t.id != ? ORDER BY RANDOM() LIMIT ?');
        $stmt->bindValue(1, $trackId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
