<?php
    $host = 'localhost';
    $db   = 'webcoffee';
    $user = 'root';
    $pass = ''; 
    $charset = 'utf8mb4';

    // Cấu hình DSN (Data Source Name) cho PDO
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Báo lỗi dạng Exception để dễ debug
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mặc định trả về mảng kết hợp
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Tắt giả lập prepare để bảo mật hơn
    ];

    try {
        // Khởi tạo kết nối PDO
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Nếu lỗi thì dừng và hiện thông báo
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
?>