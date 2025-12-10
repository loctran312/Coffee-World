<?php
    session_start();
    include_once('../config/database.php');

    // Kiểm tra quyền admin (Bảo mật)
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        die("Access Denied");
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            // Lấy thông tin ảnh TRƯỚC khi xóa record
            $stmt = $pdo->prepare("SELECT image_url FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch();

            // Kiểm tra và xóa ảnh trong thư mục
            if ($product && !empty($product['image_url'])) {
                // Đường dẫn tới file ảnh (Từ thư mục process đi ra ngoài 1 cấp -> vào img)
                $file_path = "../img/" . $product['image_url'];

                // Kiểm tra xem file có tồn tại không và đó có phải là file thật không
                if (file_exists($file_path) && is_file($file_path)) {
                    
                    if ($product['image_url'] !== 'default.png') {
                        unlink($file_path);
                    }
                }
            }

            // Xóa dữ liệu trong Database
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $_SESSION['success'] = "Đã xóa sản phẩm và hình ảnh kèm theo!";

        } catch (PDOException $e) {
            $_SESSION['error'] = "Lỗi khi xóa: " . $e->getMessage();
        }
    }

    // Quay về trang admin
    header("Location: ../admin.php");
    exit();
?>