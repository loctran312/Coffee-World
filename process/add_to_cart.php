<?php
    session_start();
    include_once('../config/database.php');

    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../signin.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if ($quantity <= 0) $quantity = 1;

        try {
            // Kiểm tra xem User đã có Cart chưa
            $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $cart = $stmt->fetch();

            if ($cart) {
                $cart_id = $cart['id'];
            } else {
                // Nếu chưa có, tạo giỏ hàng mới
                $stmt = $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->execute([$user_id]);
                $cart_id = $pdo->lastInsertId();
            }

            // Lấy giá sản phẩm hiện tại
            $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            
            if (!$product) {
                die("Sản phẩm không tồn tại");
            }
            $price = $product['price'];

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $stmt = $pdo->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$cart_id, $product_id]);
            $existing_item = $stmt->fetch();

            if ($existing_item) {
                // Nếu đã có: Cập nhật số lượng
                $new_quantity = $existing_item['quantity'] + $quantity;
                $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                $stmt->execute([$new_quantity, $existing_item['id']]);
            } else {
                // Nếu chưa có: Thêm mới vào cart_items
                $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$cart_id, $product_id, $quantity, $price]);
            }

            // Thông báo và quay lại trang chi tiết
            $_SESSION['cart_success'] = "Đã thêm vào giỏ hàng thành công!";
            header("Location: ../product_detail.php?id=" . $product_id);
            exit();

        } catch (PDOException $e) {
            die("Lỗi giỏ hàng: " . $e->getMessage());
        }
    } else {
        header("Location: ../shop.php");
    }
?>