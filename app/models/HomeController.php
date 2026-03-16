<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Track.php';

class HomeController extends Controller {
    public function index(): void {
        $trackModel = new Track();
        $tracks = $trackModel->all();
        $this->view('home', ['tracks' => $tracks]);
    }

    public function stream(): void {
        $trackModel = new Track();
        $tracks = $trackModel->all();
        $this->view('stream', ['tracks' => $tracks]);
    }

    public function library(): void {
        $trackModel = new Track();
        $tracks = $trackModel->all();
        $this->view('library', ['tracks' => $tracks]);
    }
}
