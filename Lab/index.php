<?php
session_start();

$base_dir = __DIR__; 

// Lấy đường dẫn từ tham số 'dir'
$current_dir = isset($_GET['dir']) ? $_GET['dir'] : '';

// Xử lý các dấu gạch chéo dư thừa và bảo mật
$current_dir = trim($current_dir, '/'); 
$current_dir = trim($current_dir, '\\'); 

// Bảo mật: Ngăn chặn người dùng truy cập ra khỏi thư mục Lab
if (strpos($current_dir, '..') !== false) {
    $current_dir = ''; // Reset về gốc nếu phát hiện nghi vấn
}

// Đường dẫn thực tế để quét
$scan_path = $base_dir . ($current_dir ? '/' . $current_dir : '');

// Xử lý nếu đường dẫn trỏ đến một FILE
if (is_file($scan_path)) {
    header("Location: " . $current_dir);
    exit();
}

// Kiểm tra thư mục có tồn tại không
if (!is_dir($scan_path)) {
    die("Thư mục không tồn tại.");
}

// Quét file và thư mục
$items = scandir($scan_path);
$folders = [];
$files = [];

foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue; 
    if ($item === 'index.php' && $current_dir === '') continue; 
    if ($item === '.htaccess') continue; 

    $full_path = $scan_path . '/' . $item;
    
    if (is_dir($full_path)) {
        $folders[] = $item;
    } else {
        $files[] = $item;
    }
}

// Logic Navbar
$is_logged_in = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài tập Lab</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .lab-container { max-width: 1200px; margin: 30px auto; padding: 0 15px; }

        .breadcrumb { background: #f8f9fa; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px; font-size: 16px; }
        .breadcrumb a { color: #4b2e05; text-decoration: none; font-weight: bold; }
        .breadcrumb span { color: #6c757d; }

        .lab-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        
        .lab-card { 
            background: white; border: 1px solid #ddd; border-radius: 8px; 
            padding: 20px; text-align: center; transition: transform 0.2s, box-shadow 0.2s;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 150px; text-decoration: none; color: #333;
        }
        
        .lab-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-color: #4b2e05; }
        
        .icon { font-size: 40px; margin-bottom: 10px; }
        .folder-icon { color: #ffc107; } /* Màu vàng cho folder */
        .file-icon { color: #17a2b8; }   /* Màu xanh cho file */
        
        .lab-name { font-weight: bold; word-break: break-word; }
        
        .back-btn { display: inline-block; margin-bottom: 15px; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; }
        .back-btn:hover { background: #5a6268; }
    </style>
</head>
<body>

    <div class="banner">
        <h1>Coffee World - Lab Center</h1>
    </div>

    <div class="navbar">
        <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="../about.php">About</a>
            <a href="../shop.php">Shop</a>
            <a href="../cart.php">Cart</a>
            <a href="index.php" style="font-weight: bold; text-decoration: underline;">Lab</a>
        </div>
        
        <div class="nav-links">
            <?php if ($is_logged_in): ?>
                <a href="../<?php echo ($role === 'admin') ? 'admin.php' : '#'; ?>">
                    <span>User: <b><?php echo htmlspecialchars($username); ?></b></span>
                </a>
            <?php else: ?>
                <a href="../signin.php">Sign In</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="lab-container">
        
        <div class="breadcrumb">
            <a href="index.php">Lab Root</a>
            <?php if ($current_dir): 
                $path_parts = explode('/', $current_dir);
                $current_link = '';
                foreach ($path_parts as $part):
                    if (empty($part)) continue;
                    $current_link .= '/' . $part;
            ?>
                    <span> / </span>
                    <a href="index.php?dir=<?php echo urlencode(trim($current_link, '/')); ?>">
                        <?php echo htmlspecialchars($part); ?>
                    </a>
            <?php endforeach; endif; ?>
        </div>

        <?php if ($current_dir): 
            $parent_dir = dirname($current_dir);
            if ($parent_dir === '.') $parent_dir = '';
        ?>
            <a href="index.php?dir=<?php echo urlencode($parent_dir); ?>" class="back-btn">⬅ Quay lại</a>
        <?php endif; ?>

        <div class="lab-grid">
            <?php foreach ($folders as $folder): 
                // Tạo link: index.php?dir=folder_hien_tai/folder_con
                $link_dir = $current_dir ? $current_dir . '/' . $folder : $folder;
            ?>
                <a href="index.php?dir=<?php echo urlencode($link_dir); ?>" class="lab-card">
                    <div class="icon folder-icon">📁</div>
                    <div class="lab-name"><?php echo htmlspecialchars($folder); ?></div>
                </a>
            <?php endforeach; ?>

            <?php foreach ($files as $file): 
                // Tạo link trực tiếp tới file để chạy
                $link_file = $current_dir ? $current_dir . '/' . $file : $file;
            ?>
                <a href="<?php echo htmlspecialchars($link_file); ?>" class="lab-card" target="_blank">
                    <div class="icon file-icon">📄</div>
                    <div class="lab-name"><?php echo htmlspecialchars($file); ?></div>
                </a>
            <?php endforeach; ?>

            <?php if (empty($folders) && empty($files)): ?>
                <p>Thư mục trống.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>