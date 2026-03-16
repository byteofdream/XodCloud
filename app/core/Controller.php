<?php
class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/partials/footer.php';
    }

    protected function viewPlain(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    protected function redirect(string $path): void {
        header('Location: ' . $path);
        exit;
    }
}
