<?php
    session_start();
    include_once('config/database.php');

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php"); exit();
    }

    // Lấy thông tin sản phẩm cần sửa
    $id = $_GET['id'] ?? null;
    if (!$id) { header("Location: admin.php"); exit(); }

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container { max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #4b2e05; color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sửa sản phẩm: <?php echo htmlspecialchars($product['name']); ?></h2>
        <form action="process/product_edit_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            
            <label>Giá (VNĐ):</label>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            
            <label>Mô tả:</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
            
            <label>Hình ảnh mới (Để trống nếu không đổi):</label>
            <input type="file" name="image">
            <input type="hidden" name="current_image" value="<?php echo $product['image_url']; ?>">

            <button type="submit">Cập nhật</button>
        </form>
        <br>
        <a href="admin.php">Quay lại</a>
    </div>
</body>
</html>