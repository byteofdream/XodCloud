<?php
require_once __DIR__ . '/../core/Model.php';

class Follow extends Model {
    public function toggle(int $followerId, int $followingId): void {
        if ($followerId === $followingId) {
            return;
        }
        if ($this->isFollowing($followerId, $followingId)) {
            $stmt = $this->db->prepare('DELETE FROM follows WHERE follower_id = ? AND following_id = ?');
            $stmt->execute([$followerId, $followingId]);
            return;
        }
        $stmt = $this->db->prepare('INSERT INTO follows (follower_id, following_id) VALUES (?, ?)');
        $stmt->execute([$followerId, $followingId]);
    }

    public function isFollowing(int $followerId, int $followingId): bool {
        $stmt = $this->db->prepare('SELECT id FROM follows WHERE follower_id = ? AND following_id = ?');
        $stmt->execute([$followerId, $followingId]);
        return (bool)$stmt->fetch();
    }

    public function countFollowers(int $userId): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) AS cnt FROM follows WHERE following_id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return (int)$row['cnt'];
    }

    public function countFollowing(int $userId): int {
        $stmt = $this->db->prepare('SELECT COUNT(*) AS cnt FROM follows WHERE follower_id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return (int)$row['cnt'];
    }
}
