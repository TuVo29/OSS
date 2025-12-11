-- Tạo database
CREATE DATABASE IF NOT EXISTS kho_hang;
USE kho_hang;

-- Tạo bảng sản phẩm
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu
INSERT INTO products (name, category, quantity, unit_price, description) VALUES
('Laptop Dell XPS 13', 'Điện tử', 5, 25000000, 'Laptop cao cấp, hiệu năng tốt'),
('Chuột không dây Logitech', 'Phụ kiện', 20, 500000, 'Chuột không dây tiện lợi'),
('Bàn phím cơ Corsair', 'Phụ kiện', 8, 2500000, 'Bàn phím cơ chuyên game'),
('Monitor LG 27 inch', 'Điện tử', 3, 5000000, 'Màn hình 4K rất sắc nét');
