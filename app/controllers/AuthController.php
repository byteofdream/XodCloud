<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    public function login(): void {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $this->redirect('/index.php');
            } else {
                $error = 'Invalid email or password.';
            }
        }

        $this->view('login', ['error' => $error]);
    }

    public function register(): void {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $email === '' || $password === '') {
                $error = 'All fields are required.';
            } else {
                $userModel = new User();
                if ($userModel->findByEmail($email)) {
                    $error = 'Email already registered.';
                } else {
                    $userId = $userModel->create([
                        'username' => $username,
                        'display_name' => $username,
                        'email' => $email,
                        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                        'avatar' => '/assets/img/default-avatar.svg',
                        'banner' => '/assets/img/banner-default.svg',
                        'bio' => 'New here. Sharing sounds soon.'
                    ]);
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['username'] = $username;
                    $this->redirect('/user.php?u=' . urlencode($username));
                }
            }
        }

        $this->view('register', ['error' => $error]);
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/index.php');
    }
}
