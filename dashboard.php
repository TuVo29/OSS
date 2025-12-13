<?php
include 'config/db.php';

// Tính toán thống kê chính
$stats_sql = "SELECT COUNT(*) as total_products, SUM(quantity) as total_quantity, SUM(quantity * unit_price) as total_value FROM products";
$stats = $conn->query($stats_sql)->fetch_assoc();

// Sản phẩm sắp hết hàng (quantity <= 5)
$low_stock_sql = "SELECT COUNT(*) as low_stock FROM products WHERE quantity <= 5";
$low_stock = $conn->query($low_stock_sql)->fetch_assoc();

// Danh mục sản phẩm
$categories_sql = "SELECT COUNT(DISTINCT category) as total_categories FROM products";
$categories = $conn->query($categories_sql)->fetch_assoc();

// Top 5 sản phẩm có giá trị cao nhất
$top_value_sql = "SELECT name, quantity, unit_price, (quantity * unit_price) as total_value FROM products ORDER BY (quantity * unit_price) DESC LIMIT 5";
$top_value_result = $conn->query($top_value_sql);

// Thống kê theo danh mục
$category_stats_sql = "SELECT category, COUNT(*) as count, SUM(quantity) as quantity, SUM(quantity * unit_price) as value FROM products GROUP BY category ORDER BY value DESC";
$category_stats = $conn->query($category_stats_sql);

// Top 5 sản phẩm có số lượng nhiều nhất
$top_quantity_sql = "SELECT name, quantity, category FROM products ORDER BY quantity DESC LIMIT 5";
$top_quantity_result = $conn->query($top_quantity_sql);

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<div class="page-header">
    <h1>📊 Dashboard</h1>
    <p>Tổng quan hệ thống quản lý kho hàng</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $stats['total_products']; ?></div>
            <div class="stat-label">Tổng Sản Phẩm</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $stats['total_quantity']; ?></div>
            <div class="stat-label">Tổng Số Lượng</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo number_format($stats['total_value'], 0); ?></div>
            <div class="stat-label">Tổng Giá Trị (VNĐ)</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🏷️</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $categories['total_categories']; ?></div>
            <div class="stat-label">Danh Mục</div>
        </div>
    </div>

    <div class="stat-card alert">
        <div class="stat-icon">⚠️</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $low_stock['low_stock']; ?></div>
            <div class="stat-label">Sắp Hết Hàng</div>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="dashboard-grid">
    <!-- Top Products by Value -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3>💎 Top 5 Sản Phẩm Có Giá Trị Cao Nhất</h3>
        </div>
        <div class="card-body">
            <?php if ($top_value_result->num_rows > 0): ?>
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Đơn Giá</th>
                            <th>Tổng Giá Trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $top_value_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo number_format($row['unit_price'], 0); ?> VNĐ</td>
                                <td><strong><?php echo number_format($row['total_value'], 0); ?> VNĐ</strong></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-message">Không có sản phẩm nào</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Products by Quantity -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3>📚 Top 5 Sản Phẩm Có Số Lượng Nhiều Nhất</h3>
        </div>
        <div class="card-body">
            <?php if ($top_quantity_result->num_rows > 0): ?>
                <table class="mini-table">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Số Lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $top_quantity_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><strong><?php echo $row['quantity']; ?></strong></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-message">Không có sản phẩm nào</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Category Stats -->
<div class="dashboard-card full-width">
    <div class="card-header">
        <h3>📊 Thống Kê Theo Danh Mục</h3>
    </div>
    <div class="card-body">
        <?php if ($category_stats->num_rows > 0): ?>
            <table class="mini-table">
                <thead>
                    <tr>
                        <th>Danh Mục</th>
                        <th>Số Sản Phẩm</th>
                        <th>Tổng Số Lượng</th>
                        <th>Tổng Giá Trị</th>
                        <th>% Giá Trị</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_value_all = $stats['total_value'];
                    while ($row = $category_stats->fetch_assoc()): 
                        $percentage = $total_value_all > 0 ? ($row['value'] / $total_value_all) * 100 : 0;
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['category']); ?></strong></td>
                            <td><?php echo $row['count']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo number_format($row['value'], 0); ?> VNĐ</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                    <span><?php echo round($percentage, 1); ?>%</span>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-message">Không có dữ liệu danh mục</p>
        <?php endif; ?>
    </div>
</div>

<div class="dashboard-actions">
    <a href="add_product.php" class="btn btn-success">+ Thêm Sản Phẩm</a>
    <a href="reports.php" class="btn btn-info">Xem Báo Cáo Chi Tiết</a>
    <a href="low_stock.php" class="btn btn-warning">Xem Hàng Sắp Hết</a>
</div>

<?php include 'includes/footer.php'; ?>
