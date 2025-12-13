<?php
// Header dengan navigation menu
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Quản Lý Kho Hàng'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>📦 Kho</h2>
                <p class="subtitle">Quản Lý</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                            <span class="icon">📊</span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                            <span class="icon">📋</span>
                            <span class="text">Sản Phẩm</span>
                        </a>
                    </li>
                    <li>
                        <a href="categories.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'categories.php') ? 'active' : ''; ?>">
                            <span class="icon">🏷️</span>
                            <span class="text">Danh Mục</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php' || basename($_SERVER['PHP_SELF']) == 'add_order.php' || basename($_SERVER['PHP_SELF']) == 'edit_order.php') ? 'active' : ''; ?>">
                            <span class="icon">🛒</span>
                            <span class="text">Đơn Hàng</span>
                        </a>
                    </li>
                    <li>
                        <a href="reports.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>">
                            <span class="icon">📈</span>
                            <span class="text">Báo Cáo</span>
                        </a>
                    </li>
                    <li>
                        <a href="low_stock.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'low_stock.php') ? 'active' : ''; ?>">
                            <span class="icon">⚠️</span>
                            <span class="text">Cảnh Báo Hàng</span>
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
                            <span class="icon">⚙️</span>
                            <span class="text">Cài Đặt</span>
                        </a>
                    </li>
                    <li style="border-top: 1px solid rgba(255,255,255,0.2); margin-top: 10px;">
                        <a href="sitemap.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'sitemap.php') ? 'active' : ''; ?>">
                            <span class="icon">🗺️</span>
                            <span class="text">Site Map</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <p class="version">v1.0.0</p>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
