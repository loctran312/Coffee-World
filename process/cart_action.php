<?php
    session_start();
    include_once('../config/database.php');

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../signin.php");
        exit();
    }

    // Xử lý xóa sản phẩm (GET request)
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $item_id = $_GET['id'];
        
        // Đảm bảo chỉ xóa đúng item của cart người dùng đó (để bảo mật)
        // Cần join bảng carts để check user_id
        $sql = "DELETE cart_items FROM cart_items 
                JOIN carts ON cart_items.cart_id = carts.id
                WHERE cart_items.id = ? AND carts.user_id = ?";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item_id, $_SESSION['user_id']]);
        
        header("Location: ../cart.php");
        exit();
    }

    // Xử lý cập nhật số lượng (POST request)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
        
        if (isset($_POST['qty']) && is_array($_POST['qty'])) {
            foreach ($_POST['qty'] as $item_id => $quantity) {
                $quantity = (int)$quantity;
                if ($quantity < 1) $quantity = 1; // Không cho phép số lượng < 1

                // Cập nhật từng dòng
                $sql = "UPDATE cart_items 
                        JOIN carts ON cart_items.cart_id = carts.id
                        SET cart_items.quantity = ? 
                        WHERE cart_items.id = ? AND carts.user_id = ?";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$quantity, $item_id, $_SESSION['user_id']]);
            }
        }
        
        header("Location: ../cart.php");
        exit();
    }

    // Mặc định quay về cart
    header("Location: ../cart.php");
    exit();
?>