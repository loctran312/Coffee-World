<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php"); exit();
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container { max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #4b2e05; color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Thêm sản phẩm mới</h2>
        <form action="process/product_add_process.php" method="POST" enctype="multipart/form-data">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" required>
            
            <label>Giá (VNĐ):</label>
            <input type="number" name="price" required>
            
            <label>Mô tả:</label>
            <textarea name="description" rows="4"></textarea>
            
            <label>Hình ảnh:</label>
            <input type="file" name="image" required>

            <button type="submit">Thêm sản phẩm</button>
        </form>
        <br>
        <a href="admin.php">Quay lại</a>
    </div>
</body>
</html>