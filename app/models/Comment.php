<?php
require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {
    public function forTrack(int $trackId): array {
        $stmt = $this->db->prepare('SELECT c.*, u.username, u.avatar FROM comments c JOIN users u ON u.id = c.user_id WHERE c.track_id = ? ORDER BY c.created_at DESC');
        $stmt->execute([$trackId]);
        return $stmt->fetchAll();
    }

    public function create(int $trackId, int $userId, string $body): void {
        $stmt = $this->db->prepare('INSERT INTO comments (track_id, user_id, body) VALUES (?, ?, ?)');
        $stmt->execute([$trackId, $userId, $body]);
    }
}
