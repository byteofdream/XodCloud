<?php
session_start();

require_once __DIR__ . '/app/core/Router.php';

$router = new Router();

$router->get('home', ['HomeController', 'index']);
$router->get('stream', ['HomeController', 'stream']);
$router->get('library', ['HomeController', 'library']);
$router->get('track', ['TrackController', 'show']);
$router->post('track-comment', ['TrackController', 'comment']);
$router->post('track-react', ['TrackController', 'react']);
$router->get('profile', ['UserController', 'profile']);
$router->get('user', ['UserController', 'profileByUsername']);
$router->post('follow', ['UserController', 'follow']);
$router->get('upload', ['UploadController', 'form']);
$router->post('upload-save', ['UploadController', 'store']);
$router->get('search', ['SearchController', 'index']);
$router->get('messages', ['MessageController', 'inbox']);
$router->post('message-send', ['MessageController', 'send']);
$router->get('settings', ['SettingsController', 'edit']);
$router->post('settings', ['SettingsController', 'edit']);
$router->get('login', ['AuthController', 'login']);
$router->post('login', ['AuthController', 'login']);
$router->get('register', ['AuthController', 'register']);
$router->post('register', ['AuthController', 'register']);
$router->get('logout', ['AuthController', 'logout']);

$route = defined('ROUTE') ? ROUTE : ($_GET['route'] ?? 'home');
$router->dispatch($route, $_SERVER['REQUEST_METHOD']);
