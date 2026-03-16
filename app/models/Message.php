<?php
require_once __DIR__ . '/../core/Model.php';

class Message extends Model {
    public function inbox(int $userId): array {
        $stmt = $this->db->prepare('SELECT m.*, u.username, u.avatar FROM messages m JOIN users u ON u.id = m.sender_id WHERE m.receiver_id = ? ORDER BY m.created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function send(int $senderId, int $receiverId, string $body): void {
        if ($senderId === $receiverId) {
            return;
        }
        $stmt = $this->db->prepare('INSERT INTO messages (sender_id, receiver_id, body) VALUES (?, ?, ?)');
        $stmt->execute([$senderId, $receiverId, $body]);
    }
}
