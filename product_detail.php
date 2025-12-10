<?php
session_start();
include_once('config/database.php');

// Lấy ID từ URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: shop.php");
    exit();
}

// Lấy thông tin chi tiết sản phẩm
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch();

// Nếu không tìm thấy sản phẩm
if (!$product) {
    echo "Sản phẩm không tồn tại!";
    exit();
}

// Logic Navbar
$is_logged_in = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? 'user';
$profile_link = ($is_logged_in && $role === 'admin') ? 'admin.php' : '#';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detail-container { max-width: 1000px; margin: 50px auto; display: flex; gap: 40px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .detail-img { flex: 1; }
        .detail-img img { width: 100%; border-radius: 10px; }
        .detail-info { flex: 1; padding: 20px; }
        .detail-info h2 { color: #4b2e05; margin-top: 0; }
        .detail-price { color: #d9534f; font-size: 24px; font-weight: bold; margin: 20px 0; }
        .detail-desc { line-height: 1.6; color: #555; margin-bottom: 30px; }
        
        .add-cart-form { display: flex; align-items: center; gap: 10px; }
        .qty-input { width: 60px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; text-align: center; }
        .btn-add-cart { background-color: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; font-size: 16px; }
        .btn-add-cart:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop</a>
        </div>
        <div class="nav-links">
            <?php if ($is_logged_in): ?>
                <a href="<?php echo $profile_link; ?>"><span><?php echo htmlspecialchars($username); ?></span></a>
                <a href="process/logout.php">Log Out</a>
            <?php else: ?>
                <a href="signin.php">Sign In</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="detail-container">
        <div class="detail-img">
            <img src="img/<?php echo !empty($product['image_url']) ? $product['image_url'] : 'default.png'; ?>" alt="Product Image">
        </div>
        <div class="detail-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <div class="detail-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</div>
            <p class="detail-desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <form action="process/add_to_cart.php" method="POST" class="add-cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label>Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1" class="qty-input">
                
                <?php if ($is_logged_in): ?>
                    <button type="submit" class="btn-add-cart">Thêm vào giỏ hàng</button>
                <?php else: ?>
                    <a href="signin.php" style="color: red;">Đăng nhập để mua hàng</a>
                <?php endif; ?>
            </form>
            
            <?php if (isset($_SESSION['cart_success'])): ?>
                <p style="color: green; margin-top: 10px;"><?php echo $_SESSION['cart_success']; unset($_SESSION['cart_success']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>