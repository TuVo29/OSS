<?php
include '../config/db.php';

$page_title = 'Cảnh Báo Hàng Sắp Hết';
include '../includes/header.php';

// Lấy danh sách sản phẩm sắp hết hàng
$low_stock_sql = "SELECT * FROM products WHERE quantity <= 5 ORDER BY quantity ASC";
$low_stock_result = $conn->query($low_stock_sql);

// Thống kê
$stats_sql = "SELECT COUNT(*) as count, SUM(quantity) as qty, SUM(quantity * unit_price) as value FROM products WHERE quantity <= 5";
$stats = $conn->query($stats_sql)->fetch_assoc();
?>

<div class="page-header">
    <h1>⚠️ Cảnh Báo Hàng Sắp Hết</h1>
    <p>Các sản phẩm có số lượng ≤ 5</p>
</div>

<!-- Stats -->
<div class="alert-stats">
    <div class="alert-stat">
        <div class="alert-stat-value"><?php echo $stats['count']; ?></div>
        <div class="alert-stat-label">Sản Phẩm Cảnh Báo</div>
    </div>
    <div class="alert-stat">
        <div class="alert-stat-value"><?php echo $stats['qty']; ?></div>
        <div class="alert-stat-label">Tổng Số Lượng</div>
    </div>
    <div class="alert-stat">
        <div class="alert-stat-value"><?php echo number_format($stats['value'], 0); ?></div>
        <div class="alert-stat-label">Tổng Giá Trị (VNĐ)</div>
    </div>
</div>

<!-- Low Stock Table -->
<div class="table-container">
    <?php if ($low_stock_result->num_rows > 0): ?>
        <table class="alert-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản Phẩm</th>
                    <th>Danh Mục</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Tổng Giá Trị</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $low_stock_result->fetch_assoc()): ?>
                    <tr class="low-stock-row">
                        <td>#<?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td class="quantity-alert">
                            <strong><?php echo $row['quantity']; ?> ⚠️</strong>
                        </td>
                        <td><?php echo number_format($row['unit_price'], 0); ?> VNĐ</td>
                        <td><?php echo number_format($row['quantity'] * $row['unit_price'], 0); ?> VNĐ</td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">✏️ Sửa</a>
                                <a href="add_product.php?restock=<?php echo $row['id']; ?>" class="btn btn-success">📦 Nhập Kho</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state success">
            <p>✅ Tất cả sản phẩm đều có số lượng đủ (> 5)</p>
            <a href="index.php" class="btn">Xem Danh Sách Sản Phẩm</a>
        </div>
    <?php endif; ?>
</div>

<div class="alert-actions">
    <a href="dashboard.php" class="btn">← Dashboard</a>
    <a href="reports.php" class="btn">Xem Báo Cáo</a>
</div>

<?php include '../includes/footer.php'; ?>
