<?php
    session_start();
    // Kiểm tra người dùng đã đăng nhập hay chưa
    $is_logged_in = isset($_SESSION['user_id']);
    $username = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>
    <link rel="stylesheet" href="css/style.css">
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

    <!-- Nội dung -->
    <div class="content">
        <h2>Khám phá hương vị cà phê đích thực ☕</h2>
        <p>Trang web này dành cho những người yêu thích cà phê và muốn tìm hiểu thêm về thế giới của hạt cà phê.</p>
    </div>
</body>
</html>