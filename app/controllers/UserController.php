<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Track.php';
require_once __DIR__ . '/../models/Follow.php';

class UserController extends Controller {
    public function profile(): void {
        $id = (int)($_GET['id'] ?? 0);
        $userModel = new User();
        $trackModel = new Track();
        $followModel = new Follow();

        $user = $userModel->findById($id);
        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        $tracks = $trackModel->findByUser($id);
        $isFollowing = isset($_SESSION['user_id']) ? $followModel->isFollowing((int)$_SESSION['user_id'], $id) : false;
        $followersCount = $followModel->countFollowers($id);
        $followingCount = $followModel->countFollowing($id);
        $this->view('profile', [
            'profileUser' => $user,
            'tracks' => $tracks,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }

    public function profileByUsername(): void {
        $username = trim($_GET['u'] ?? '');
        if ($username === '') {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        $userModel = new User();
        $trackModel = new Track();
        $followModel = new Follow();

        $user = $userModel->findByUsername($username);
        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        $tracks = $trackModel->findByUser((int)$user['id']);
        $isFollowing = isset($_SESSION['user_id']) ? $followModel->isFollowing((int)$_SESSION['user_id'], (int)$user['id']) : false;
        $followersCount = $followModel->countFollowers((int)$user['id']);
        $followingCount = $followModel->countFollowing((int)$user['id']);
        $this->view('profile', [
            'profileUser' => $user,
            'tracks' => $tracks,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }

    public function follow(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $targetId = (int)($_POST['user_id'] ?? 0);
        if ($targetId) {
            $followModel = new Follow();
            $followModel->toggle((int)$_SESSION['user_id'], $targetId);
        }

        $this->redirect('/profile.php?id=' . $targetId);
    }
}
