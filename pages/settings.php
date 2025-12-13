<?php
include '../config/db.php';

$page_title = 'Cài Đặt';
include '../includes/header.php';

// Load settings from JSON file or database
$settings_file = 'config/settings.json';
$settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : [];

// Default settings
$defaults = [
    'app_name' => 'Hệ Thống Quản Lý Kho',
    'low_stock_threshold' => 5,
    'currency' => 'VNĐ',
    'date_format' => 'Y-m-d H:i:s',
    'company_name' => 'Công Ty',
    'contact_email' => 'contact@example.com',
    'language' => 'vi'
];

$settings = array_merge($defaults, $settings);

// Handle save settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings['app_name'] = $_POST['app_name'];
    $settings['low_stock_threshold'] = (int)$_POST['low_stock_threshold'];
    $settings['currency'] = $_POST['currency'];
    $settings['date_format'] = $_POST['date_format'];
    $settings['company_name'] = $_POST['company_name'];
    $settings['contact_email'] = $_POST['contact_email'];
    $settings['language'] = $_POST['language'];
    
    // Create config directory if it doesn't exist
    if (!is_dir('config')) {
        mkdir('config', 0755, true);
    }
    
    if (file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        $success_message = "✅ Cài đặt đã được lưu thành công!";
    } else {
        $error_message = "❌ Lỗi: Không thể lưu cài đặt!";
    }
}

// Get database info
$db_info_sql = "SELECT COUNT(*) as product_count FROM products";
$db_info = $conn->query($db_info_sql)->fetch_assoc();
?>

<div class="page-header">
    <h1>⚙️ Cài Đặt Hệ Thống</h1>
    <p>Quản lý cấu hình ứng dụng</p>
</div>

<?php if (isset($success_message)): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <div class="alert alert-error"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="settings-grid">
    <!-- Settings Form -->
    <div class="settings-card">
        <h2>⚙️ Cài Đặt Ứng Dụng</h2>
        <form method="POST" class="settings-form">
            <div class="form-group">
                <label for="app_name">Tên Ứng Dụng</label>
                <input type="text" id="app_name" name="app_name" value="<?php echo htmlspecialchars($settings['app_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="company_name">Tên Công Ty</label>
                <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($settings['company_name']); ?>">
            </div>

            <div class="form-group">
                <label for="contact_email">Email Liên Hệ</label>
                <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email']); ?>">
            </div>

            <div class="form-group">
                <label for="low_stock_threshold">Ngưỡng Cảnh Báo Hàng (Số Lượng)</label>
                <input type="number" id="low_stock_threshold" name="low_stock_threshold" value="<?php echo $settings['low_stock_threshold']; ?>" min="1">
            </div>

            <div class="form-group">
                <label for="currency">Tiền Tệ</label>
                <select id="currency" name="currency">
                    <option value="VNĐ" <?php echo $settings['currency'] == 'VNĐ' ? 'selected' : ''; ?>>VNĐ (Vietnamese Dong)</option>
                    <option value="USD" <?php echo $settings['currency'] == 'USD' ? 'selected' : ''; ?>>USD (US Dollar)</option>
                    <option value="EUR" <?php echo $settings['currency'] == 'EUR' ? 'selected' : ''; ?>>EUR (Euro)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="language">Ngôn Ngữ</label>
                <select id="language" name="language">
                    <option value="vi" <?php echo $settings['language'] == 'vi' ? 'selected' : ''; ?>>Tiếng Việt</option>
                    <option value="en" <?php echo $settings['language'] == 'en' ? 'selected' : ''; ?>>English</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_format">Định Dạng Ngày Giờ</label>
                <select id="date_format" name="date_format">
                    <option value="Y-m-d H:i:s" <?php echo $settings['date_format'] == 'Y-m-d H:i:s' ? 'selected' : ''; ?>>YYYY-MM-DD HH:MM:SS</option>
                    <option value="d/m/Y H:i" <?php echo $settings['date_format'] == 'd/m/Y H:i' ? 'selected' : ''; ?>>DD/MM/YYYY HH:MM</option>
                    <option value="m/d/Y" <?php echo $settings['date_format'] == 'm/d/Y' ? 'selected' : ''; ?>>MM/DD/YYYY</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">💾 Lưu Cài Đặt</button>
        </form>
    </div>

    <!-- System Info -->
    <div class="settings-card">
        <h2>ℹ️ Thông Tin Hệ Thống</h2>
        <div class="info-box">
            <div class="info-item">
                <span class="info-label">Phiên Bản Ứng Dụng</span>
                <span class="info-value">v1.0.0</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phiên Bản PHP</span>
                <span class="info-value"><?php echo phpversion(); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Máy Chủ Web</span>
                <span class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Tổng Sản Phẩm Trong Kho</span>
                <span class="info-value"><?php echo $db_info['product_count']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Database</span>
                <span class="info-value"><?php echo DB_NAME; ?> @ <?php echo DB_HOST; ?></span>
            </div>
        </div>

        <h3>📚 Tài Liệu & Hỗ Trợ</h3>
        <div class="support-links">
            <a href="README.md" class="link-button">📖 Hướng Dẫn Sử Dụng</a>
            <a href="index.php" class="link-button">📋 Quay Lại Danh Sách</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
