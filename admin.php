<?php 
    session_start();
    include_once('config/database.php');

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }

    // Lấy danh sách sản phẩm
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container { padding: 20px; max-width: 1200px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4b2e05; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; margin-right: 5px; }
        .btn-add { background-color: #28a745; display: inline-block; padding: 10px 20px; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; }
        .product-img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="nav-links"><a href="index.php">Về trang chủ</a></div>
        <div class="nav-links"><span>Admin Panel</span></div>
    </div>

    <div class="admin-container">
        <h2>Danh sách sản phẩm</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <a href="product_add.php" class="btn btn-add">+ Thêm sản phẩm mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td>
                        <?php if($p['image_url']): ?>
                            <img src="img/<?php echo $p['image_url']; ?>" class="product-img">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo number_format($p['price']); ?> VNĐ</td>
                    <td><?php echo htmlspecialchars(substr($p['description'], 0, 50)) . '...'; ?></td>
                    <td>
                        <a href="product_edit.php?id=<?php echo $p['id']; ?>" class="btn btn-edit">Sửa</a>
                        <a href="process/product_delete_process.php?id=<?php echo $p['id']; ?>" class="btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>