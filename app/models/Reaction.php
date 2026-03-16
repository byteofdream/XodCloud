<?php
require_once __DIR__ . '/../core/Model.php';

class Reaction extends Model {
    public function countForTrack(int $trackId, string $type): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) as cnt FROM reactions WHERE track_id = ? AND type = ?');
        $stmt->execute([$trackId, $type]);
        $row = $stmt->fetch();
        return (int)$row['cnt'];
    }

    public function hasReacted(int $trackId, int $userId, string $type): bool {
        $stmt = $this->db->prepare('SELECT id FROM reactions WHERE track_id = ? AND user_id = ? AND type = ?');
        $stmt->execute([$trackId, $userId, $type]);
        return (bool)$stmt->fetch();
    }

    public function toggle(int $trackId, int $userId, string $type): void {
        if ($this->hasReacted($trackId, $userId, $type)) {
            $stmt = $this->db->prepare('DELETE FROM reactions WHERE track_id = ? AND user_id = ? AND type = ?');
            $stmt->execute([$trackId, $userId, $type]);
            return;
        }

        $stmt = $this->db->prepare('INSERT INTO reactions (track_id, user_id, type) VALUES (?, ?, ?)');
        $stmt->execute([$trackId, $userId, $type]);
    }
}
