CREATE DATABASE IF NOT EXISTS webcoffee;
USE webcoffee;

-- Tạo bảng users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    passwd VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm user mẫu
INSERT INTO users (username, email, passwd, role)
VALUES ('user1', 'user1@gmail.com', 'hashed_pass', 'user');

-- Tạo bảng categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm categories
INSERT INTO categories (name)
VALUES ('Espresso'), ('Latte'), ('Cappuccino');

-- Tạo bảng products
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    category_id INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_category 
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm products mẫu
INSERT INTO products (name, description, price, stock, category_id, image_url)
VALUES 
('Espresso Đà Lạt', 'Hương thơm nhẹ, vị chua thanh', 180000, 50, 1, 'espresso.jpg'),
('Latte Buôn Ma Thuột', 'Đậm vị, caffeine cao', 120000, 80, 2, 'latte.jpg');

-- Tạo bảng carts
CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_user 
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm cart cho user_id = 1
INSERT INTO carts (user_id)
VALUES (1);

-- Tạo bảng cart_items
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_cartitem_cart 
        FOREIGN KEY (cart_id) REFERENCES carts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_cartitem_product 
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT unique_cart_product UNIQUE(cart_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Thêm cart_items mẫu
INSERT INTO cart_items (cart_id, product_id, quantity, price)
VALUES
(1, 1, 1, 180000),
(1, 2, 2, 120000);
