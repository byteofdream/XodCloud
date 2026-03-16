<?php
class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config.php';
            $db = $config['db'];
            if (($db['driver'] ?? '') === 'sqlite') {
                $dsn = 'sqlite:' . $db['path'];
                self::$instance = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                self::$instance->exec('PRAGMA foreign_keys = ON;');
            } else {
                $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";
                self::$instance = new PDO($dsn, $db['user'], $db['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            }
        }

        return self::$instance;
    }
}
