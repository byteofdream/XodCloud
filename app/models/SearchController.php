<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Track.php';

class SearchController extends Controller {
    public function index(): void {
        $term = trim($_GET['q'] ?? '');
        $trackModel = new Track();
        $results = $term !== '' ? $trackModel->search($term) : [];
        $this->view('search', ['term' => $term, 'results' => $results]);
    }
}
