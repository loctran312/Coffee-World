<?php
    session_start();
    include_once('config/database.php');

    // Logic Navbar
    $is_logged_in = isset($_SESSION['user_id']);
    $username = $_SESSION['username'] ?? '';
    $role = $_SESSION['role'] ?? 'user';
    $profile_link = ($is_logged_in && $role === 'admin') ? 'admin.php' : '#';

    $cart_items = [];
    $grand_total = 0;

    if ($is_logged_in) {
        $user_id = $_SESSION['user_id'];
        
        // Lấy danh sách sản phẩm trong giỏ hàng của User
        // Kết nối bảng cart_items với products để lấy tên và ảnh
        // Kết nối bảng cart_items với carts để lọc theo user_id
        $sql = "SELECT ci.id as item_id, ci.quantity, ci.product_id, 
                    p.name, p.price, p.image_url 
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                JOIN carts c ON ci.cart_id = c.id
                WHERE c.user_id = ?";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $cart_items = $stmt->fetchAll();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .cart-container { max-width: 1000px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .cart-table th, .cart-table td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        .cart-table th { background-color: #f8f9fa; color: #4b2e05; }
        .cart-img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
        
        .qty-input { width: 60px; padding: 5px; text-align: center; border: 1px solid #ccc; border-radius: 4px; }
        .btn-update { background-color: #ffc107; color: black; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 12px; }
        .btn-remove { background-color: #dc3545; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; font-size: 14px; }
        .btn-remove:hover { background-color: #c82333; }
        
        .cart-summary { text-align: right; margin-top: 20px; }
        .total-price { font-size: 24px; font-weight: bold; color: #d9534f; }
        .btn-checkout { background-color: #4b2e05; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px; }
        .btn-checkout:hover { background-color: #6f4e37; }
        
        /* CSS cho Navbar tìm kiếm (giữ nguyên như bài trước) */
        .search-form { display: flex; align-items: center; background: #fff; border-radius: 20px; padding: 2px 10px; border: 1px solid #ccc; }
        .search-form input { border: none; outline: none; padding: 5px; font-size: 14px; width: 150px; }
        .search-form button { background: none; border: none; cursor: pointer; font-size: 16px; padding: 0 5px; color: #4b2e05; }
    </style>
</head>
<body>

    <!-- Banner -->
    <div class="banner">
        <h1>Welcome to Coffee World</h1>
    </div>

    <!-- Thanh menu -->
    <div class="navbar">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="shop.php">Shop</a>
            <a href="cart.php">Cart</a> <a href="Lab/">Lab</a>
        </div>



        <div class="nav-links" style="display: flex; align-items: center; gap: 10px;">
            <form action="shop.php" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Tìm kiếm..." required>
                <button type="submit">🔍</button>
            </form>

            <?php if ($is_logged_in): ?>
                <a href="<?php echo $profile_link; ?>">
                    <span>Chào mừng, <b><?php echo htmlspecialchars($username); ?></b></span>
                </a>
                <a href="process/logout.php">Log Out</a>
            <?php else: ?>
                <a href="signup.php">Sign Up</a>
                <a href="signin.php">Sign In</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="cart-container">
        <h2 style="color: #4b2e05; margin-bottom: 20px;">Giỏ hàng của bạn 🛒</h2>
        
        <?php if (!$is_logged_in): ?>
            <p style="text-align: center;">Vui lòng <a href="signin.php" style="color: blue;">đăng nhập</a> để xem giỏ hàng.</p>
        
        <?php elseif (empty($cart_items)): ?>
            <p style="text-align: center; padding: 30px;">Giỏ hàng của bạn đang trống.</p>
            <div style="text-align: center;"><a href="shop.php" class="btn-checkout">Tiếp tục mua sắm</a></div>
        
        <?php else: ?>
            <form action="process/cart_action.php" method="POST">
                <input type="hidden" name="action" value="update">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): 
                            $total_line = $item['price'] * $item['quantity'];
                            $grand_total += $total_line;
                        ?>
                        <tr>
                            <td data-label="Sản phẩm" style="display: flex; align-items: center; gap: 10px;">
                                <img src="img/<?php echo !empty($item['image_url']) ? $item['image_url'] : 'default.png'; ?>" class="cart-img">
                                <b><?php echo htmlspecialchars($item['name']); ?></b>
                            </td>
                            <td data-label="Giá"><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                            <td data-label="Số lượng">
                                <input type="number" name="qty[<?php echo $item['item_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="qty-input">
                            </td>
                            <td data-label="Thành tiền"><?php echo number_format($total_line, 0, ',', '.'); ?> đ</td>
                            <td data-label="Hành động">
                                <a href="process/cart_action.php?action=delete&id=<?php echo $item['item_id']; ?>" class="btn-remove" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button type="submit" class="btn-update">🔄 Cập nhật số lượng</button>
                    
                    <div class="cart-summary">
                        <span>Tổng cộng:</span>
                        <div class="total-price"><?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ</div>
                        <br>
                        <a href="#" class="btn-checkout" onclick="alert('Chức năng thanh toán đang phát triển!'); return false;">Tiến hành thanh toán</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <h3>Liên Hệ</h3>
            <p>Địa chỉ: 180 Cao Lỗ, phường Chánh Hưng</p>
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">Twitter</a>
            </div>
            <div class="copyright">
                &copy; Coffee World. The author is YoshiIT
            </div>
        </div>
    </div>

</body>
</html>
