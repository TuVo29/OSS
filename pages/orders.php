<?php
include '../config/db.php';

$page_title = 'Quản Lý Đơn Hàng';
include '../includes/header.php';

// Xóa đơn hàng
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM order_items WHERE order_id = $delete_id");
    $conn->query("DELETE FROM orders WHERE id = $delete_id");
    header('Location: orders.php');
    exit;
}

// Lấy danh sách đơn hàng
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<div class="page-header">
    <h1>🛒 Quản Lý Đơn Hàng</h1>
    <a href="add_order.php" class="btn btn-primary">➕ Thêm Đơn Hàng Mới</a>
</div>

<div class="content">
    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <p>📭 Chưa có đơn hàng nào</p>
            <a href="add_order.php" class="btn btn-primary">Tạo đơn hàng đầu tiên</a>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Khách Hàng</th>
                    <th>Email</th>
                    <th>Điện Thoại</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Tiền</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($order['order_code']); ?></strong></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_email'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_phone'] ?? 'N/A'); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
                                <?php echo $order['status']; ?>
                            </span>
                        </td>
                        <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> ₫</td>
                        <td class="action-buttons">
                            <a href="edit_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
                            <a href="orders.php?delete_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa đơn hàng này?');">🗑️ Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.status-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-chờ-xử-lý {
    background-color: #fff3cd;
    color: #856404;
}

.status-đang-giao {
    background-color: #cfe2ff;
    color: #084298;
}

.status-hoàn-thành {
    background-color: #d1e7dd;
    color: #0f5132;
}

.status-hủy {
    background-color: #f8d7da;
    color: #842029;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.data-table thead {
    background: #f5f5f5;
}

.data-table th, .data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.data-table tbody tr:hover {
    background-color: #f9f9f9;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #999;
}
</style>

<?php include '../includes/footer.php'; ?>
