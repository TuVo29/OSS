<?php
include '../config/db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_email = $_POST['customer_email'] ?? '';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $status = $_POST['status'] ?? 'Chờ xử lý';
    $notes = $_POST['notes'] ?? '';
    
    if (empty($customer_name)) {
        $message = 'Vui lòng nhập tên khách hàng!';
        $message_type = 'error';
    } else {
        // Tạo mã đơn hàng
        $order_code = 'ORD' . date('YmdHis') . rand(100, 999);
        
        $customer_name = $conn->real_escape_string($customer_name);
        $customer_email = $conn->real_escape_string($customer_email);
        $customer_phone = $conn->real_escape_string($customer_phone);
        $notes = $conn->real_escape_string($notes);
        
        $sql = "INSERT INTO orders (order_code, customer_name, customer_email, customer_phone, status, notes, total_amount) 
                VALUES ('$order_code', '$customer_name', '$customer_email', '$customer_phone', '$status', '$notes', 0)";
        
        if ($conn->query($sql)) {
            $order_id = $conn->insert_id;
            $message = 'Thêm đơn hàng thành công! Mã đơn: ' . $order_code;
            $message_type = 'success';
            
            // Xử lý các sản phẩm trong đơn hàng
            if (isset($_POST['products']) && is_array($_POST['products'])) {
                $total_amount = 0;
                foreach ($_POST['products'] as $index => $product_id) {
                    if (empty($product_id)) continue;
                    
                    $product_id = intval($product_id);
                    $quantity = intval($_POST['quantities'][$index] ?? 0);
                    $unit_price = floatval($_POST['unit_prices'][$index] ?? 0);
                    
                    if ($quantity > 0 && $unit_price > 0) {
                        $subtotal = $quantity * $unit_price;
                        $total_amount += $subtotal;
                        
                        $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) 
                                     VALUES ($order_id, $product_id, $quantity, $unit_price, $subtotal)";
                        $conn->query($sql_item);
                    }
                }
                
                // Cập nhật tổng tiền đơn hàng
                $sql_update = "UPDATE orders SET total_amount = $total_amount WHERE id = $order_id";
                $conn->query($sql_update);
            }
            
            $_POST = [];
        } else {
            $message = 'Lỗi: ' . $conn->error;
            $message_type = 'error';
        }
    }
}

// Lấy danh sách sản phẩm
$products_sql = "SELECT id, name, unit_price FROM products ORDER BY name";
$products_result = $conn->query($products_sql);
$products = [];
if ($products_result && $products_result->num_rows > 0) {
    while ($row = $products_result->fetch_assoc()) {
        $products[] = $row;
    }
}

$page_title = 'Thêm Đơn Hàng';
include '../includes/header.php';
?>

<div class="page-header">
    <h1>🛒 Thêm Đơn Hàng Mới</h1>
    <p>Nhập thông tin khách hàng và chọn sản phẩm</p>
</div>

<?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <form method="POST" id="orderForm">
        <div class="form-section">
            <h3>Thông Tin Khách Hàng</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Tên Khách Hàng <span class="required">*</span></label>
                    <input type="text" name="customer_name" placeholder="Nhập tên khách hàng" required value="<?php echo $_POST['customer_name'] ?? ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="customer_email" placeholder="Nhập email" value="<?php echo $_POST['customer_email'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Điện Thoại</label>
                    <input type="tel" name="customer_phone" placeholder="Nhập số điện thoại" value="<?php echo $_POST['customer_phone'] ?? ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Trạng Thái</label>
                    <select name="status">
                        <option value="Chờ xử lý">Chờ xử lý</option>
                        <option value="Đang giao">Đang giao</option>
                        <option value="Hoàn thành">Hoàn thành</option>
                        <option value="Hủy">Hủy</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Ghi Chú</label>
                <textarea name="notes" placeholder="Nhập ghi chú thêm..." rows="3"><?php echo $_POST['notes'] ?? ''; ?></textarea>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Chọn Sản Phẩm</h3>
            
            <div id="products-container">
                <div class="product-item">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Sản Phẩm</label>
                            <select name="products[]" class="product-select" onchange="updatePrice(this)">
                                <option value="">-- Chọn sản phẩm --</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['unit_price']; ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Giá (₫)</label>
                            <input type="number" name="unit_prices[]" placeholder="0" readonly class="unit-price-input">
                        </div>
                        
                        <div class="form-group">
                            <label>Số Lượng</label>
                            <input type="number" name="quantities[]" placeholder="0" min="0" value="1">
                        </div>
                        
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger" onclick="removeProduct(this)">🗑️ Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn btn-secondary" onclick="addProduct()">➕ Thêm Sản Phẩm</button>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Lưu Đơn Hàng</button>
            <a href="orders.php" class="btn btn-secondary">← Quay Lại</a>
        </div>
    </form>
</div>

<style>
.form-container {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    margin-top: 0;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.25);
}

.required {
    color: red;
}

.product-item {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    padding: 8px 15px;
}

.btn-danger:hover {
    background-color: #c82333;
}

.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<script>
function updatePrice(select) {
    const price = select.options[select.selectedIndex].getAttribute('data-price');
    select.closest('.product-item').querySelector('.unit-price-input').value = price || '';
}

function addProduct() {
    const container = document.getElementById('products-container');
    const newItem = document.querySelector('.product-item').cloneNode(true);
    
    // Reset giá trị
    newItem.querySelector('select').value = '';
    newItem.querySelector('.unit-price-input').value = '';
    newItem.querySelector('input[name="quantities[]"]').value = '1';
    
    container.appendChild(newItem);
}

function removeProduct(btn) {
    const items = document.querySelectorAll('.product-item');
    if (items.length > 1) {
        btn.closest('.product-item').remove();
    } else {
        alert('Phải có ít nhất một sản phẩm!');
    }
}
</script>

<?php include '../includes/footer.php'; ?>
