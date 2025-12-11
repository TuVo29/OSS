<?php
include 'config/db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $unit_price = $_POST['unit_price'] ?? 0;
    $description = $_POST['description'] ?? '';

    // Kiểm tra dữ liệu
    if (empty($name) || empty($category)) {
        $message = 'Vui lòng điền đầy đủ thông tin!';
        $message_type = 'error';
    } else {
        $name = $conn->real_escape_string($name);
        $category = $conn->real_escape_string($category);
        $description = $conn->real_escape_string($description);

        $sql = "INSERT INTO products (name, category, quantity, unit_price, description) 
                VALUES ('$name', '$category', '$quantity', '$unit_price', '$description')";

        if ($conn->query($sql)) {
            $message = 'Thêm sản phẩm thành công!';
            $message_type = 'success';
            // Xóa form
            $_POST = [];
        } else {
            $message = 'Lỗi: ' . $conn->error;
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>➕ Thêm Sản Phẩm Mới</h1>
            <div class="header-info">Nhập thông tin sản phẩm cần thêm vào kho</div>
        </header>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Tên Sản Phẩm <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Danh Mục <span style="color: red;">*</span></label>
                    <select id="category" name="category" required>
                        <option value="">-- Chọn Danh Mục --</option>
                        <option value="Điện tử" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Điện tử') ? 'selected' : ''; ?>>Điện tử</option>
                        <option value="Phụ kiện" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Phụ kiện') ? 'selected' : ''; ?>>Phụ kiện</option>
                        <option value="Thời trang" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Thời trang') ? 'selected' : ''; ?>>Thời trang</option>
                        <option value="Sách" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Sách') ? 'selected' : ''; ?>>Sách</option>
                        <option value="Khác" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Số Lượng</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($_POST['quantity'] ?? 0); ?>" min="0">
                </div>

                <div class="form-group">
                    <label for="unit_price">Đơn Giá (VNĐ)</label>
                    <input type="number" id="unit_price" name="unit_price" value="<?php echo htmlspecialchars($_POST['unit_price'] ?? 0); ?>" min="0" step="1000">
                </div>

                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">✅ Thêm Sản Phẩm</button>
                    <a href="index.php" class="btn">❌ Hủy</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
