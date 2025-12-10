<?php
    session_start();
    // Kiểm tra người dùng đã đăng nhập hay chưa
    $is_logged_in = isset($_SESSION['user_id']);
    $username = $_SESSION['username'] ?? '';
    $role = $_SESSION['role'] ?? 'user';

    $profile_link = '#';
    if ($is_logged_in && $role === 'admin') {
        $profile_link = 'admin.php';
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Website</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="google-site-verification" content="vQvhr97ZFjJNnkGWSK94QNDzKqLIaqOHvR7FsrxynPA" />
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

        <h2>Các loại coffee</h2>
        <div class="card-container">
            <div class="card">
                <img src="img/Espresso.png" alt="Espresso">
                <h3>Espresso</h3>
            </div>
            <div class="card">
                <img src="img/Latte.png" alt="Latte">
                <h3>Latte</h3>
            </div>
            <div class="card">
                <img src="img/Capuchino.png" alt="Cappuccino">
                <h3>Cappuccino</h3>
            </div>
            <div class="card">
                <img src="img/Mocha.png" alt="Mocha">
                <h3>Mocha</h3>
            </div>
            <div class="card">
                <img src="/img/flat-white.png" alt="Flat White">
                <h3>Flat White</h3>
            </div>
            <div class="card">
                <img src="img/Irish.png" alt="Irish Coffee">
                <h3>Irish</h3>
            </div>
            <div class="card">
                <img src="img/Finn.png" alt="Black Coffee">
                <h3>Finn</h3>
            </div>
            <div class="card">
                <img src="img/Turkish-Coffee.png" alt="Turkish Coffee">
                <h3>Turkish</h3>
            </div>
            <div class="card">
                <img src="img/Vienna Coffee.png" alt="Vienna Coffee">
                <h3>Vienna</h3>
            </div>
        </div>
    </div>
    
</body>
</html>
