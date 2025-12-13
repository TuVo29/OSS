<?php
include '../config/db.php';

// Lấy danh sách sản phẩm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products";

if ($search) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
}

$sql .= " ORDER BY updated_at DESC";
$result = $conn->query($sql);

// Tính toán thống kê
$stats_sql = "SELECT COUNT(*) as total_products, SUM(quantity) as total_quantity, SUM(quantity * unit_price) as total_value FROM products";
$stats = $conn->query($stats_sql)->fetch_assoc();

// Sản phẩm sắp hết hàng (quantity <= 5)
$low_stock_sql = "SELECT COUNT(*) as low_stock FROM products WHERE quantity <= 5";
$low_stock = $conn->query($low_stock_sql)->fetch_assoc();

$page_title = 'Danh Sách Sản Phẩm';
include '../includes/header.php';
?>

<div class="page-header">
    <h1>📋 Danh Sách Sản Phẩm</h1>
    <p>Quản lý toàn bộ sản phẩm trong kho</p>
</div>

<!-- Nút thêm sản phẩm -->
<div class="button-group">
    <a href="add_product.php" class="btn btn-success">+ Thêm Sản Phẩm</a>
    <a href="dashboard.php" class="btn">📊 Dashboard</a>
</div>

<!-- Tìm kiếm -->
<div class="search-box">
    <form method="GET" action="" class="form-inline">
        <div class="form-group" style="flex: 1;">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn">🔍 Tìm Kiếm</button>
        <?php if ($search): ?>
            <a href="index.php" class="btn btn-warning">Xóa Bộ Lọc</a>
        <?php endif; ?>
    </form>
</div>

<!-- Bảng sản phẩm -->
<div class="table-container">
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Danh Mục</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Tổng Giá Trị</th>
                    <th>Mô Tả</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td class="<?php echo $row['quantity'] <= 5 ? 'quantity-low' : 'quantity-ok'; ?>">
                            <?php echo $row['quantity']; ?>
                            <?php if ($row['quantity'] <= 5): ?>
                                <span> ⚠️</span>
                            <?php endif; ?>
                        </td>
                        <td class="price"><?php echo number_format($row['unit_price'], 0); ?> VNĐ</td>
                        <td class="price"><?php echo number_format($row['quantity'] * $row['unit_price'], 0); ?> VNĐ</td>
                        <td><?php echo substr(htmlspecialchars($row['description']), 0, 30) . (strlen($row['description']) > 30 ? '...' : ''); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">✏️ Sửa</a>
                                <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>📭 Không tìm thấy sản phẩm nào</p>
            <a href="add_product.php" class="btn btn-success">Thêm sản phẩm ngay</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
