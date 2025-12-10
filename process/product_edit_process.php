<?php
    session_start();
    include_once('../config/database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $current_image = $_POST['current_image'];
        
        $image_url = $current_image; // Mặc định giữ ảnh cũ

        // Nếu người dùng chọn ảnh mới
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../img/";
            $image_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $image_name;
            }
        }

        $sql = "UPDATE products SET name = ?, price = ?, description = ?, image_url = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $description, $image_url, $id]);

        $_SESSION['success'] = "Cập nhật thành công!";
        header("Location: ../admin.php");
        exit();
    }
?>