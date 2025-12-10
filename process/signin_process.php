<?php
    session_start();
    include_once('../config/database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dẽ liệu từ form
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Kiểm tra tính hợp lệ cơ bản
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ username và password';
            header('Location: ../signin.php');
            exit();
        }

        $sql = "SELECT
                    id,
                    username,
                    passwd,
                    role FROM users 
                    where username = :username";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();

            // Kiểm tra user có tồn tại không
            if ($user) {
                // Xác minh mật khẩu
                if (password_verify($password, $user['passwd'])) { 
                    // Đăng nhập thành công

                    // Lưu thông tin user vào session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Chuyển hướng đến trang chính
                    header('Location: ../index.php');
                    exit();
                } else {
                    // Sai password
                    $_SESSION['error'] = 'Username hoặc Password không đúng.';

                }
            } else {
                // User không tồn tại
                $_SESSION['error'] = 'Username hoặc Password không đúng.';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Lỗi hệ thống khi đăng nhập';
        }
    }

    // Nếu có lỗi hoặc truy cập không qua POST, chuyển hướng về trang đăng nhập
    header('Location: ../signin.php');
    exit();
?>