<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class SettingsController extends Controller {
    public function edit(): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }

        $userModel = new User();
        $user = $userModel->findById((int)$_SESSION['user_id']);
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $displayName = trim($_POST['display_name'] ?? '');
            $bio = trim($_POST['bio'] ?? '');

            if ($username === '' || $displayName === '') {
                $error = 'Username and display name are required.';
            } else {
                $currentAvatar = $user['avatar'];
                $currentBanner = $user['banner'];

                $avatarPath = $this->handleImageUpload('avatar', 'avatars', $currentAvatar);
                $bannerPath = $this->handleImageUpload('banner', 'banners', $currentBanner);

                $userModel->updateSettings((int)$_SESSION['user_id'], [
                    'username' => $username,
                    'display_name' => $displayName,
                    'bio' => $bio,
                    'avatar' => $avatarPath,
                    'banner' => $bannerPath
                ]);

                $_SESSION['username'] = $username;
                $user = $userModel->findById((int)$_SESSION['user_id']);
                $success = 'Settings saved.';
            }
        }

        $this->viewPlain('settings', [
            'user' => $user,
            'error' => $error,
            'success' => $success
        ]);
    }

    private function handleImageUpload(string $field, string $folder, string $fallback): string {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            return $fallback;
        }

        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            return $fallback;
        }

        $filename = uniqid($field . '_', true) . '.' . $ext;
        $dest = __DIR__ . '/../../uploads/' . $folder . '/' . $filename;
        move_uploaded_file($_FILES[$field]['tmp_name'], $dest);

        return '/uploads/' . $folder . '/' . $filename;
    }
}
