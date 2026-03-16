<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Track.php';

class UploadController extends Controller {
    public function form(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $this->view('upload');
    }

    public function store(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $duration = trim($_POST['duration'] ?? '3:24');

        if ($title === '' || !isset($_FILES['audio'])) {
            $this->redirect('/upload.php?error=1');
        }

        $audio = $_FILES['audio'];
        if ($audio['error'] !== UPLOAD_ERR_OK) {
            $this->redirect('/upload.php?error=1');
        }

        $ext = strtolower(pathinfo($audio['name'], PATHINFO_EXTENSION));
        if ($ext !== 'mp3') {
            $this->redirect('/upload.php?error=1');
        }

        $filename = uniqid('track_', true) . '.mp3';
        $dest = __DIR__ . '/../../uploads/' . $filename;
        move_uploaded_file($audio['tmp_name'], $dest);

        $trackModel = new Track();
        $trackId = $trackModel->create([
            'user_id' => (int)$_SESSION['user_id'],
            'title' => $title,
            'description' => $description,
            'audio_path' => '/uploads/' . $filename,
            'cover_path' => '/assets/img/cover-default.svg',
            'duration' => $duration
        ]);

        $this->redirect('/track.php?id=' . $trackId);
    }
}
