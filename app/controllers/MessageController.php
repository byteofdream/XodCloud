<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';

class MessageController extends Controller {
    public function inbox(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $messageModel = new Message();
        $messages = $messageModel->inbox((int)$_SESSION['user_id']);
        $this->view('messages', ['messages' => $messages]);
    }

    public function send(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $receiverId = (int)($_POST['receiver_id'] ?? 0);
        $body = trim($_POST['body'] ?? '');
        if ($receiverId && $body !== '') {
            $messageModel = new Message();
            $messageModel->send((int)$_SESSION['user_id'], $receiverId, $body);
        }

        $this->redirect('/profile.php?id=' . $receiverId);
    }
}
