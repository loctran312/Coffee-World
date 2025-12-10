<?php
    session_start();
    include_once('../config/database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        // Xử lý upload ảnh
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../img/"; // Lưu vào thư mục img
            $image_name = time() . "_" . basename($_FILES["image"]["name"]); // Đổi tên tránh trùng
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $image_name; // Chỉ lưu tên file vào DB
            }
        }

        $sql = "INSERT INTO products (name, price, description, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $description, $image_url]);

        $_SESSION['success'] = "Thêm sản phẩm thành công!";
        header("Location: ../admin.php");
        exit();
    }
?>