<?php
include 'config/db.php';

$message = '';
$message_type = '';
$product = null;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if (!$product) {
        $message = 'Sản phẩm không tồn tại!';
        $message_type = 'error';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id > 0) {
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

        $sql = "UPDATE products SET name='$name', category='$category', quantity='$quantity', 
                unit_price='$unit_price', description='$description' WHERE id=$id";

        if ($conn->query($sql)) {
            $message = 'Cập nhật sản phẩm thành công!';
            $message_type = 'success';
            // Tải lại dữ liệu
            $result = $conn->query("SELECT * FROM products WHERE id = $id");
            $product = $result->fetch_assoc();
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
    <title>Chỉnh Sửa Sản Phẩm</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>✏️ Chỉnh Sửa Sản Phẩm</h1>
            <div class="header-info">Cập nhật thông tin sản phẩm</div>
        </header>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($product): ?>
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Tên Sản Phẩm <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Danh Mục <span style="color: red;">*</span></label>
                    <select id="category" name="category" required>
                        <option value="">-- Chọn Danh Mục --</option>
                        <option value="Điện tử" <?php echo $product['category'] == 'Điện tử' ? 'selected' : ''; ?>>Điện tử</option>
                        <option value="Phụ kiện" <?php echo $product['category'] == 'Phụ kiện' ? 'selected' : ''; ?>>Phụ kiện</option>
                        <option value="Thời trang" <?php echo $product['category'] == 'Thời trang' ? 'selected' : ''; ?>>Thời trang</option>
                        <option value="Sách" <?php echo $product['category'] == 'Sách' ? 'selected' : ''; ?>>Sách</option>
                        <option value="Khác" <?php echo $product['category'] == 'Khác' ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Số Lượng</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" min="0">
                </div>

                <div class="form-group">
                    <label for="unit_price">Đơn Giá (VNĐ)</label>
                    <input type="number" id="unit_price" name="unit_price" value="<?php echo $product['unit_price']; ?>" min="0" step="1000">
                </div>

                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <p style="font-size: 12px; color: #7f8c8d;">
                        <strong>Cập nhật lần cuối:</strong> <?php echo date('d/m/Y H:i', strtotime($product['updated_at'])); ?>
                    </p>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">✅ Cập Nhật</button>
                    <a href="index.php" class="btn">❌ Hủy</a>
                </div>
            </form>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <p>❌ Sản phẩm không tồn tại!</p>
            <a href="index.php" class="btn">← Quay Lại</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
