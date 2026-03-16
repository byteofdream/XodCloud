<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Track.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Reaction.php';

class TrackController extends Controller {
    public function show(): void {
        $id = (int)($_GET['id'] ?? 0);
        $trackModel = new Track();
        $commentModel = new Comment();
        $reactionModel = new Reaction();

        $track = $trackModel->find($id);
        if (!$track) {
            http_response_code(404);
            echo 'Track not found';
            return;
        }

        $comments = $commentModel->forTrack($id);
        $related = $trackModel->related($id);
        $likes = $reactionModel->countForTrack($id, 'like');
        $reposts = $reactionModel->countForTrack($id, 'repost');

        $this->view('track', [
            'track' => $track,
            'comments' => $comments,
            'related' => $related,
            'likes' => $likes,
            'reposts' => $reposts
        ]);
    }

    public function comment(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $trackId = (int)($_POST['track_id'] ?? 0);
        $body = trim($_POST['body'] ?? '');
        if ($trackId && $body !== '') {
            $commentModel = new Comment();
            $commentModel->create($trackId, (int)$_SESSION['user_id'], $body);
        }

        $this->redirect('/track.php?id=' . $trackId);
    }

    public function react(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $trackId = (int)($_POST['track_id'] ?? 0);
        $type = $_POST['type'] ?? 'like';
        if (!in_array($type, ['like', 'repost'], true)) {
            $type = 'like';
        }

        if ($trackId) {
            $reactionModel = new Reaction();
            $reactionModel->toggle($trackId, (int)$_SESSION['user_id'], $type);
        }

        $this->redirect('/track.php?id=' . $trackId);
    }
}
