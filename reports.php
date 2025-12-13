<?php
include 'config/db.php';

$page_title = 'Báo Cáo';
include 'includes/header.php';

// Tính toán thống kê
$stats_sql = "SELECT COUNT(*) as total_products, SUM(quantity) as total_quantity, SUM(quantity * unit_price) as total_value FROM products";
$stats = $conn->query($stats_sql)->fetch_assoc();

// Sản phẩm sắp hết hàng
$low_stock_sql = "SELECT COUNT(*) as low_stock FROM products WHERE quantity <= 5";
$low_stock = $conn->query($low_stock_sql)->fetch_assoc();

// Giá trị trung bình
$avg_price = $stats['total_products'] > 0 ? ($stats['total_value'] / $stats['total_quantity']) : 0;

// Sản phẩm có giá cao nhất
$max_price_sql = "SELECT name, unit_price FROM products ORDER BY unit_price DESC LIMIT 1";
$max_price = $conn->query($max_price_sql)->fetch_assoc();

// Sản phẩm có giá thấp nhất
$min_price_sql = "SELECT name, unit_price FROM products ORDER BY unit_price ASC LIMIT 1";
$min_price = $conn->query($min_price_sql)->fetch_assoc();

// Danh mục có giá trị cao nhất
$top_category_sql = "SELECT category, SUM(quantity * unit_price) as value FROM products GROUP BY category ORDER BY value DESC LIMIT 1";
$top_category = $conn->query($top_category_sql)->fetch_assoc();
?>

<div class="page-header">
    <h1>📈 Báo Cáo Hệ Thống</h1>
    <p>Phân tích chi tiết kho hàng</p>
</div>

<!-- General Stats -->
<div class="report-section">
    <h2>📊 Thống Kê Chung</h2>
    <div class="report-grid">
        <div class="report-card">
            <div class="report-label">Tổng Sản Phẩm</div>
            <div class="report-value"><?php echo $stats['total_products']; ?></div>
        </div>
        <div class="report-card">
            <div class="report-label">Tổng Số Lượng Hàng</div>
            <div class="report-value"><?php echo $stats['total_quantity']; ?></div>
        </div>
        <div class="report-card">
            <div class="report-label">Tổng Giá Trị Kho</div>
            <div class="report-value"><?php echo number_format($stats['total_value'], 0); ?> VNĐ</div>
        </div>
        <div class="report-card">
            <div class="report-label">Giá Trị Bình Quân</div>
            <div class="report-value"><?php echo number_format($avg_price, 0); ?> VNĐ/SP</div>
        </div>
    </div>
</div>

<!-- Price Analysis -->
<div class="report-section">
    <h2>💰 Phân Tích Giá</h2>
    <div class="report-grid">
        <div class="report-card">
            <div class="report-label">Giá Cao Nhất</div>
            <div class="report-value"><?php echo $max_price ? number_format($max_price['unit_price'], 0) . ' VNĐ' : 'N/A'; ?></div>
            <div class="report-subtext"><?php echo $max_price ? htmlspecialchars($max_price['name']) : ''; ?></div>
        </div>
        <div class="report-card">
            <div class="report-label">Giá Thấp Nhất</div>
            <div class="report-value"><?php echo $min_price ? number_format($min_price['unit_price'], 0) . ' VNĐ' : 'N/A'; ?></div>
            <div class="report-subtext"><?php echo $min_price ? htmlspecialchars($min_price['name']) : ''; ?></div>
        </div>
        <div class="report-card">
            <div class="report-label">Sắp Hết Hàng</div>
            <div class="report-value" style="color: #e74c3c;"><?php echo $low_stock['low_stock']; ?></div>
            <div class="report-subtext">Sản phẩm (qty ≤ 5)</div>
        </div>
        <div class="report-card">
            <div class="report-label">Danh Mục Cao Nhất</div>
            <div class="report-value"><?php echo $top_category ? number_format($top_category['value'], 0) . ' VNĐ' : 'N/A'; ?></div>
            <div class="report-subtext"><?php echo $top_category ? htmlspecialchars($top_category['category']) : ''; ?></div>
        </div>
    </div>
</div>

<!-- Distribution by Category -->
<div class="report-section full-width">
    <h2>🏷️ Phân Bổ Theo Danh Mục</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Danh Mục</th>
                <th>Số Sản Phẩm</th>
                <th>Tổng Số Lượng</th>
                <th>Giá Trị Kho</th>
                <th>Giá Trung Bình</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $category_sql = "SELECT category, COUNT(*) as count, SUM(quantity) as qty, SUM(quantity * unit_price) as value, AVG(unit_price) as avg_price FROM products GROUP BY category ORDER BY value DESC";
            $category_result = $conn->query($category_sql);
            
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td>" . $row['count'] . "</td>";
                    echo "<td>" . $row['qty'] . "</td>";
                    echo "<td>" . number_format($row['value'], 0) . " VNĐ</td>";
                    echo "<td>" . number_format($row['avg_price'], 0) . " VNĐ</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="report-actions">
    <a href="dashboard.php" class="btn">← Quay Lại Dashboard</a>
    <a href="low_stock.php" class="btn btn-warning">Xem Cảnh Báo Hàng</a>
</div>

<?php include 'includes/footer.php'; ?>
