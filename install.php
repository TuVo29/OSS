<?php
// File cài đặt - Chạy một lần để tạo bảng và dữ liệu mẫu
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kho_hang');

// Kết nối MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die("❌ Lỗi kết nối: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Tạo database nếu chưa tồn tại
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (!$conn->query($sql_create_db)) {
    die("❌ Lỗi tạo database: " . $conn->error);
}

// Chọn database
$conn->select_db(DB_NAME);

echo "<h2>🔧 Cài Đặt Hệ Thống - Tạo Bảng Dữ Liệu</h2>";
echo "<hr>";

// Tạo bảng products
$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_products)) {
    echo "✅ Bảng 'products' - OK<br>";
} else {
    echo "❌ Lỗi tạo bảng 'products': " . $conn->error . "<br>";
}

// Tạo bảng orders
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255),
    customer_phone VARCHAR(20),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Chờ xử lý', 'Đang giao', 'Hoàn thành', 'Hủy') DEFAULT 'Chờ xử lý',
    total_amount DECIMAL(15, 2) NOT NULL DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_orders)) {
    echo "✅ Bảng 'orders' - OK<br>";
} else {
    echo "❌ Lỗi tạo bảng 'orders': " . $conn->error . "<br>";
}

// Tạo bảng order_items
$sql_order_items = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
)";

if ($conn->query($sql_order_items)) {
    echo "✅ Bảng 'order_items' - OK<br>";
} else {
    echo "❌ Lỗi tạo bảng 'order_items': " . $conn->error . "<br>";
}

echo "<hr>";

// Thêm dữ liệu mẫu vào bảng products (nếu bảng còn trống)
$check_products = $conn->query("SELECT COUNT(*) as count FROM products");
$row = $check_products->fetch_assoc();

if ($row['count'] == 0) {
    $sql_sample = "INSERT INTO products (name, category, quantity, unit_price, description) VALUES
    ('Laptop Dell XPS 13', 'Điện tử', 5, 25000000, 'Laptop cao cấp, hiệu năng tốt'),
    ('Chuột không dây Logitech', 'Phụ kiện', 20, 500000, 'Chuột không dây tiện lợi'),
    ('Bàn phím cơ Corsair', 'Phụ kiện', 8, 2500000, 'Bàn phím cơ chuyên game'),
    ('Monitor LG 27 inch', 'Điện tử', 3, 5000000, 'Màn hình 4K rất sắc nét')";
    
    if ($conn->query($sql_sample)) {
        echo "✅ Đã thêm dữ liệu mẫu vào bảng 'products'<br>";
    } else {
        echo "❌ Lỗi thêm dữ liệu mẫu: " . $conn->error . "<br>";
    }
} else {
    echo "ℹ️ Bảng 'products' đã có dữ liệu - Bỏ qua<br>";
}

echo "<hr>";
echo "<h3>✅ Cài đặt hoàn tất!</h3>";
echo "<p>🔗 <a href='pages/dashboard.php'>Vào ứng dụng</a></p>";
echo "<p style='color: red; font-weight: bold;'>⚠️ Hãy xóa file install.php sau khi cài đặt!</p>";

$conn->close();
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #f5f5f5;
}

h2, h3 {
    color: #333;
}

hr {
    margin: 20px 0;
    border: none;
    border-top: 1px solid #ddd;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
