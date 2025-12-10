<?php
    session_start();
    include_once('../config/database.php');

    // Kiểm tra xem dữ liệu POST đã được gửi chưa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra từ form loại bỏ khoảng trắng
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Kiểm tra tính hợp lệ cơ bản của dữ liệu
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
            header('Location: ../signup.php');
            exit();
        }

        // Kiểm tra độ dài username
        if (strlen($username) > 10) {
            $_SESSION['error'] = 'Tên đăng nhập không được vượt quá 10 ký tự';
            header('Location: ../signup.php');
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Truy vấn SQL chèn user mới
        $sql = "INSERT INTO users (username, email, passwd) VALUES (:username, :email, :passwd)";

        try {
            // Sử dụng Prepare Statements chặn SQL Injection
            $stmt = $pdo->prepare($sql);

            // Gán giá trị và thực thi truy vấn
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':passwd' => $hashed_password
            ]);
            $_SESSION['success'] = 'Đăng ký thành công!';
            header('Location: ../signin.php');
            exit();
        } catch (PDOException $e) {
            // Xử lý lỗi nếu username hoặc email đã tồn tại
            if ($e->getCode() == '23000') {
                $_SESSION['error'] = 'Username hoặc Email đã tồn tại';
            } else {
                $_SESSION['error'] = 'Lỗi hệ thống khi đăng nhập';
            }
            header('Location: ../signup.php');
            exit();
        } 
    } else {
        header('Location: ../signup.php');
        exit();
    }
?>