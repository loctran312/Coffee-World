<?php
    session_start();
    include_once('config/database.php');

    // Kiểm tra xem có từ khóa tìm kiếm không
    $keyword = '';
    if (isset($_GET['keyword'])) {
        $keyword = trim($_GET['keyword']);
    }

    // Chuẩn bị câu lệnh SQL
    if ($keyword) {
        $sql = "SELECT * FROM products WHERE name LIKE :key_name OR description LIKE :key_desc ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        
        // Truyền giá trị cho cả 2 tham số
        $stmt->execute([
            ':key_name' => "%$keyword%",
            ':key_desc' => "%$keyword%"
        ]);
    } else {
        // Nếu không tìm kiếm: Lấy tất cả
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    $products = $stmt->fetchAll();

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
    <title>Cửa hàng - Coffee World</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .shop-container { max-width: 1200px; margin: 30px auto; padding: 0 15px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; }
        .product-card { background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s; text-align: center; padding-bottom: 20px; }
        .product-card:hover { transform: translateY(-5px); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card h3 { margin: 15px 0 10px; color: #4b2e05; }
        .price { color: #d9534f; font-weight: bold; font-size: 1.1em; margin-bottom: 15px; display: block;}
        .btn-view { background-color: #4b2e05; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .btn-view:hover { background-color: #6f4e37; }
    </style>
</head>
<body>

    <div class="banner">
        <h1>Welcome to Coffee World</h1>
    </div>
    
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

    <div class="shop-container">
        <h2 style="text-align: center; margin-bottom: 30px; color: #4b2e05;">
            <?php 
                if ($keyword) {
                    echo 'Kết quả tìm kiếm cho: "' . htmlspecialchars($keyword) . '"';
                } else {
                    echo 'Tất cả sản phẩm';
                }
            ?>
        </h2>
        
        <div class="product-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $p): ?>
                    <div class="product-card">
                        <img src="img/<?php echo !empty($p['image_url']) ? $p['image_url'] : 'default.png'; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                        <span class="price"><?php echo number_format($p['price'], 0, ',', '.'); ?> VNĐ</span>
                        <a href="product_detail.php?id=<?php echo $p['id']; ?>" class="btn-view">Xem chi tiết</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        </div>
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
