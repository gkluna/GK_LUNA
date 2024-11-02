<?php
include "model/pdo.php";
include "model/donhang.php"; // Giả sử bạn có file model này

$id_order = $_POST['id'];


$result = cancelOrderById($id_order);

if ($result !== false) {
    echo "Đơn hàng đã được hủy thành công.";
} else {
    echo "Không thể hủy đơn hàng hoặc đơn hàng không tồn tại.";
}
?>

