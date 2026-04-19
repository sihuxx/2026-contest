<?php
// 배포 버전으로 수정
class db {
    static $db = null;

    static function __callStatic($name, $args) {
        if (self::$db === null) {
            $host = getenv('DB_HOST') ?: "localhost";
            $port = getenv('DB_PORT') ?: "3306";
            $dbname = getenv('DB_NAME') ?: "cmodule";
            $user = getenv('DB_USER') ?: "root";
            $pass = getenv('DB_PASSWORD') ?: "";

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, 
            ];

            try {
                self::$db = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("DB 연결 실패: " . $e->getMessage());
            }
        }

        return match($name) {
            "exec" => self::$db->exec($args[0]),
            "fetch" => self::$db->query($args[0])->fetch(),
            "fetchAll" => self::$db->query($args[0])->fetchAll(),
        };
    }
}