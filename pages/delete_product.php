<?php
include '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';
$message_type = '';

if ($id > 0) {
    // Kiểm tra xem sản phẩm có tồn tại không
    $check_sql = "SELECT id FROM products WHERE id = $id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $sql = "DELETE FROM products WHERE id = $id";
        if ($conn->query($sql)) {
            $message = 'Xóa sản phẩm thành công!';
            $message_type = 'success';
            // Chuyển hướng sau 1.5 giây
            header("refresh:1.5;url=index.php");
        } else {
            $message = 'Lỗi: ' . $conn->error;
            $message_type = 'error';
        }
    } else {
        $message = 'Sản phẩm không tồn tại!';
        $message_type = 'error';
    }
} else {
    $message = 'ID sản phẩm không hợp lệ!';
    $message_type = 'error';
}

$page_title = 'Xóa Sản Phẩm';
include '../includes/header.php';
?>

<div class="page-header">
    <h1>🗑️ Xóa Sản Phẩm</h1>
    <p>Kết quả xóa sản phẩm</p>
</div>

<div class="alert alert-<?php echo $message_type; ?>">
    <?php echo $message; ?>
        </div>

        <div style="text-align: center; padding: 20px;">
    <p>Chuyển hướng về danh sách sản phẩm...</p>
    <a href="index.php" class="btn">← Quay Lại Danh Sách</a>
</div>

<?php include '../includes/footer.php'; ?>
