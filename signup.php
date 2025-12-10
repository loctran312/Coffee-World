<?php
    session_start();
    include_once('config/database.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css" />
    <style>
        body {
            background-color: #fffaf3;
            font-family: "Segoe UI", sans-serif;
            margin: 0;
        }

        .signup-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4b2e05;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background-color: #7a4f08;
        }

        .footer-link {
            margin-top: 15px;
            text-align: center;
        }

        .footer-link a {
            color: #4b2e05;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            margin-bottom:
                15px;
            border-radius:
                5px;
            text-align:
                center;
            font-size:
                14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>

    <!-- Banner -->
    <div class="banner">
        <h1>Welcome to Coffee World</h1>
    </div>
    
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']); // Xóa thông báo sau khi hiện
                ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']); 
                ?>
        </div>
        <?php endif; ?>
        <form action="process/signup_process.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required />

            <button type="submit">Sign Up</button>
        </form>
        <div class="footer-link">
            Already have an account? <a href="signin.php">Sign In</a>
        </div>
    </div>
</body>

</html>