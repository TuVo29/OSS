<?php
include 'config/db.php';

$page_title = 'Quản Lý Danh Mục';
include 'includes/header.php';

// Handle add category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];
    
    if (!empty($category_name)) {
        $category_name = $conn->real_escape_string($category_name);
        $description = $conn->real_escape_string($description);
        
        $insert_sql = "INSERT INTO categories (name, description) VALUES ('$category_name', '$description')";
        if ($conn->query($insert_sql)) {
            $message = "✅ Danh mục đã được thêm thành công!";
            $message_type = "success";
        } else {
            $message = "❌ Lỗi: " . $conn->error;
            $message_type = "error";
        }
    }
}

// Get categories
$categories_sql = "SELECT * FROM (SELECT DISTINCT category FROM products) as c ORDER BY category ASC";
$categories_result = $conn->query($categories_sql);

// Get category stats
$category_stats_sql = "SELECT category, COUNT(*) as count, SUM(quantity) as qty, SUM(quantity * unit_price) as value FROM products GROUP BY category ORDER BY value DESC";
$category_stats = $conn->query($category_stats_sql);
?>

<div class="page-header">
    <h1>🏷️ Quản Lý Danh Mục</h1>
    <p>Tổng hợp và quản lý danh mục sản phẩm</p>
</div>

<?php if (isset($message)): ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- Add Category Form -->
<div class="form-section">
    <h2>➕ Thêm Danh Mục Mới</h2>
    <form method="POST" class="form-inline">
        <input type="hidden" name="action" value="add">
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="category_name" placeholder="Tên danh mục" required>
            </div>
            <div class="form-group">
                <input type="text" name="description" placeholder="Mô tả (tùy chọn)">
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
        </div>
    </form>
</div>

<!-- Categories Table -->
<div class="table-container">
    <h2>📋 Danh Sách Danh Mục</h2>
    <?php if ($category_stats->num_rows > 0): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Danh Mục</th>
                    <th>Số Sản Phẩm</th>
                    <th>Tổng Số Lượng</th>
                    <th>Tổng Giá Trị</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $category_stats->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['category']); ?></strong></td>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td><?php echo number_format($row['value'], 0); ?> VNĐ</td>
                        <td>
                            <a href="index.php?search=<?php echo urlencode($row['category']); ?>" class="btn btn-info">Xem Sản Phẩm</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="empty-message">Không có danh mục nào</p>
    <?php endif; ?>
</div>

<div class="category-actions">
    <a href="dashboard.php" class="btn">← Dashboard</a>
    <a href="index.php" class="btn">Xem Sản Phẩm</a>
</div>

<?php include 'includes/footer.php'; ?>
