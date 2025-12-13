<?php
// Quick access page for testing all new pages
$page_title = 'Site Map';
include 'includes/header.php';
?>

<div class="page-header">
    <h1>🗺️ Site Map - Bản Đồ Trang Web</h1>
    <p>Truy cập nhanh tất cả các trang trong hệ thống</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #3498db;">
        <h3>📊 Dashboard</h3>
        <p>Tổng quan hệ thống với thống kê chi tiết</p>
        <a href="dashboard.php" class="btn" style="margin-top: 10px;">Vào Dashboard</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #27ae60;">
        <h3>📋 Danh Sách Sản Phẩm</h3>
        <p>Xem, tìm kiếm, sửa, xóa sản phẩm</p>
        <a href="index.php" class="btn" style="margin-top: 10px;">Xem Danh Sách</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #f39c12;">
        <h3>➕ Thêm Sản Phẩm</h3>
        <p>Thêm sản phẩm mới vào kho</p>
        <a href="add_product.php" class="btn" style="margin-top: 10px;">Thêm Mới</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #e74c3c;">
        <h3>⚠️ Cảnh Báo Hàng</h3>
        <p>Sản phẩm sắp hết hàng (qty ≤ 5)</p>
        <a href="low_stock.php" class="btn" style="margin-top: 10px;">Xem Cảnh Báo</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #9b59b6;">
        <h3>📈 Báo Cáo</h3>
        <p>Phân tích dữ liệu chi tiết</p>
        <a href="reports.php" class="btn" style="margin-top: 10px;">Xem Báo Cáo</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #1abc9c;">
        <h3>🏷️ Danh Mục</h3>
        <p>Quản lý danh mục sản phẩm</p>
        <a href="categories.php" class="btn" style="margin-top: 10px;">Quản Lý Danh Mục</a>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 5px solid #34495e;">
        <h3>⚙️ Cài Đặt</h3>
        <p>Cấu hình hệ thống</p>
        <a href="settings.php" class="btn" style="margin-top: 10px;">Vào Cài Đặt</a>
    </div>

</div>

<!-- Documentation -->
<div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <h2>📚 Tài Liệu & Hướng Dẫn</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 15px;">
        <a href="README.md" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: #f9f9f9; border-radius: 5px; text-decoration: none; color: #2c3e50; border: 1px solid #ecf0f1;">
            <span style="font-size: 24px;">📖</span>
            <div>
                <strong>README</strong>
                <p style="font-size: 12px; color: #7f8c8d; margin: 0;">Hướng dẫn chính</p>
            </div>
        </a>
        <a href="GUIDE.md" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: #f9f9f9; border-radius: 5px; text-decoration: none; color: #2c3e50; border: 1px solid #ecf0f1;">
            <span style="font-size: 24px;">⚡</span>
            <div>
                <strong>GUIDE</strong>
                <p style="font-size: 12px; color: #7f8c8d; margin: 0;">Hướng dẫn nhanh</p>
            </div>
        </a>
        <a href="WHAT_S_NEW.md" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: #f9f9f9; border-radius: 5px; text-decoration: none; color: #2c3e50; border: 1px solid #ecf0f1;">
            <span style="font-size: 24px;">✨</span>
            <div>
                <strong>WHAT'S NEW</strong>
                <p style="font-size: 12px; color: #7f8c8d; margin: 0;">Cải tiến mới</p>
            </div>
        </a>
    </div>
</div>

<!-- Stats Summary -->
<div style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
    <h2>📊 Thông Tin Hệ Thống</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        <div>
            <div style="font-size: 32px; font-weight: bold; margin-bottom: 5px;">10</div>
            <div style="opacity: 0.9;">Trang Web</div>
        </div>
        <div>
            <div style="font-size: 32px; font-weight: bold; margin-bottom: 5px;">6</div>
            <div style="opacity: 0.9;">Mục Menu</div>
        </div>
        <div>
            <div style="font-size: 32px; font-weight: bold; margin-bottom: 5px;">15+</div>
            <div style="opacity: 0.9;">Tính Năng</div>
        </div>
        <div>
            <div style="font-size: 32px; font-weight: bold; margin-bottom: 5px;">v1.0.0</div>
            <div style="opacity: 0.9;">Phiên Bản</div>
        </div>
    </div>
</div>

<!-- Quick Facts -->
<div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2>💡 Những Điều Cần Biết</h2>
    <ul style="list-style: none; padding: 0;">
        <li style="padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
            <strong>🎯 Dashboard Menu</strong> - Sidebar cố định ở bên trái giúp dễ dàng chuyển trang
        </li>
        <li style="padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
            <strong>📱 Responsive Design</strong> - Thích ứng với desktop, tablet, mobile
        </li>
        <li style="padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
            <strong>⚠️ Cảnh Báo Tự Động</strong> - Sản phẩm qty ≤ 5 được cảnh báo
        </li>
        <li style="padding: 10px 0; border-bottom: 1px solid #ecf0f1;">
            <strong>💾 Lưu Cài Đặt</strong> - Cài đặt được lưu vào config/settings.json
        </li>
        <li style="padding: 10px 0;">
            <strong>🔐 Bảo Mật</strong> - Sử dụng htmlspecialchars() và mysqli_real_escape_string()
        </li>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
