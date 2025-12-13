# Quick Reference - Hướng Dẫn Nhanh

## 🎯 Các Trang Chính và Cách Sử Dụng

### 1️⃣ **Dashboard** - Trang Chủ Mới
- **URL**: `http://localhost/git/dashboard.php`
- **Mục đích**: Xem tổng quan hệ thống
- **Chứa**:
  - 5 thẻ thống kê: Tổng sản phẩm, tổng số lượng, tổng giá trị, danh mục, sắp hết hàng
  - Top 5 sản phẩm giá trị cao nhất
  - Top 5 sản phẩm số lượng nhiều nhất
  - Thống kê chi tiết theo danh mục

### 2️⃣ **Danh Sách Sản Phẩm** - Quản Lý Hàng
- **URL**: `http://localhost/git/index.php`
- **Mục đích**: Xem, tìm kiếm, sửa, xóa sản phẩm
- **Tính năng**:
  - Tìm kiếm theo tên hoặc danh mục
  - Hiển thị ⚠️ khi số lượng ≤ 5
  - Nút sửa/xóa cho mỗi sản phẩm
  - Liên kết nhanh đến dashboard

### 3️⃣ **Báo Cáo** - Phân Tích Dữ Liệu
- **URL**: `http://localhost/git/reports.php`
- **Mục đích**: Xem báo cáo chi tiết
- **Chứa**:
  - Thống kê chung
  - Phân tích giá (min, max, trung bình)
  - Danh mục có giá trị cao nhất
  - Bảng phân bổ theo danh mục

### 4️⃣ **Cảnh Báo Hàng** - Hàng Sắp Hết
- **URL**: `http://localhost/git/low_stock.php`
- **Mục đích**: Theo dõi sản phẩm cần nhập kho
- **Tính năng**:
  - Danh sách sản phẩm qty ≤ 5
  - Nút "Nhập Kho" nhanh chóng
  - Thống kê sản phẩm cảnh báo
  - ✅ Hiển thị thông báo khi tất cả đều OK

### 5️⃣ **Danh Mục** - Quản Lý Phân Loại
- **URL**: `http://localhost/git/categories.php`
- **Mục đích**: Quản lý và phân tích danh mục
- **Tính năng**:
  - Thêm danh mục mới
  - Xem thống kê sản phẩm/giá trị theo danh mục
  - Liên kết đến sản phẩm trong danh mục

### 6️⃣ **Cài Đặt** - Tùy Chỉnh Hệ Thống
- **URL**: `http://localhost/git/settings.php`
- **Mục đích**: Cấu hình hệ thống
- **Tùy chỉnh**:
  - ✏️ Tên ứng dụng
  - 🏢 Tên công ty
  - 📧 Email liên hệ
  - 💱 Loại tiền tệ (VNĐ, USD, EUR)
  - 🌐 Ngôn ngữ (Tiếng Việt, English)
  - 📅 Định dạng ngày giờ
  - ⚠️ Ngưỡng cảnh báo hàng

## 🎨 Sidebar Navigation

Menu bên trái cố định chứa:
- 📊 Dashboard
- 📋 Sản Phẩm
- 🏷️ Danh Mục
- 📈 Báo Cáo
- ⚠️ Cảnh Báo Hàng
- ⚙️ Cài Đặt

**Active State**: Trang hiện tại được highlight bằng màu xanh

## ➕ Thêm Sản Phẩm

1. Click nút "+ Thêm Sản Phẩm" (hoặc từ menu)
2. Điền thông tin:
   - Tên sản phẩm (bắt buộc)
   - Danh mục (bắt buộc)
   - Số lượng
   - Đơn giá
   - Mô tả
3. Click "✅ Thêm Sản Phẩm"

## ✏️ Sửa Sản Phẩm

1. Từ danh sách sản phẩm, click "✏️ Sửa"
2. Cập nhật thông tin cần sửa
3. Click "✅ Cập Nhật"
4. Sẽ hiển thị "Cập nhật lần cuối" ở dưới

## 🗑️ Xóa Sản Phẩm

1. Từ danh sách sản phẩm, click "🗑️ Xóa"
2. Xác nhận xóa trong dialog
3. Tự động chuyển hướng về danh sách

## 🔍 Tìm Kiếm

1. Từ trang danh sách sản phẩm
2. Nhập từ khóa (tên sản phẩm hoặc danh mục)
3. Click "🔍 Tìm Kiếm"
4. Kết quả được lọc theo từ khóa
5. Click "Xóa Bộ Lọc" để xem toàn bộ

## 📊 Thống Kê

### Dashboard Cards
- **📦 Tổng Sản Phẩm**: Số lượng sản phẩm trong kho
- **📚 Tổng Số Lượng**: Tổng số đơn vị hàng
- **💰 Tổng Giá Trị**: Tổng giá trị hàng tính bằng VNĐ
- **🏷️ Danh Mục**: Số danh mục có sản phẩm
- **⚠️ Sắp Hết Hàng**: Số sản phẩm có qty ≤ 5

## 💾 Lưu Cài Đặt

1. Vào Cài Đặt
2. Thay đổi các tuỳ chỉnh mong muốn
3. Click "💾 Lưu Cài Đặt"
4. Cài đặt được lưu vào `config/settings.json`

## 📁 File Cấu Trúc Mới

```
.
├── dashboard.php        ← Trang dashboard mới
├── reports.php          ← Báo cáo
├── low_stock.php        ← Cảnh báo
├── categories.php       ← Danh mục
├── settings.php         ← Cài đặt
├── includes/
│   ├── header.php       ← Sidebar + header
│   └── footer.php       ← Đóng layout
├── config/
│   ├── db.php           ← DB config
│   └── settings.json    ← Lưu cài đặt (tự động tạo)
└── css/
    └── style.css        ← CSS mới với sidebar
```

## 🎯 Gợi Ý Sử Dụng

### Kiểm Tra Hàng Mỗi Ngày
1. Vào Dashboard để xem tổng quan
2. Kiểm tra tab "Cảnh Báo Hàng" cho sản phẩm cần nhập
3. Sửa số lượng các sản phẩm sắp hết

### Phân Tích Kho
1. Xem "Báo Cáo" để phân tích chi tiết
2. Kiểm tra sản phẩm giá trị cao nhất
3. Xem phân bổ theo danh mục

### Quản Lý Hàng Tốt
1. Cần nhập hàng → vào "Cảnh Báo" → click "Nhập Kho"
2. Thay đổi giá → vào "Danh Sách" → click "Sửa"
3. Xóa hàng cũ → vào "Danh Sách" → click "Xóa"

---

**💡 Tips**: Sidebar luôn cố định, bạn có thể dễ dàng chuyển giữa các trang!
