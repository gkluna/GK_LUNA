<?php

session_start();
include "model/pdo.php";
include "model/cart.php";

// Kiểm tra xem có phải là một yêu cầu POST và dữ liệu cần thiết có tồn tại
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaBienThe'])) {
    $MaBienThe = $_POST['MaBienThe'];
  
  
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        if (deleteProductFromCart($MaBienThe, $userId)) { 
            echo "Sản phẩm đã được xóa thành công khỏi giỏ hàng của bạn.";
        } else {
            echo "Có lỗi xảy ra khi xóa sản phẩm.";
        }
    } else {
        // Người dùng chưa đăng nhập, cập nhật số lượng trong session
        if (isset($_SESSION['cart'][$MaBienThe])) {
            unset($_SESSION['cart'][$MaBienThe]);
            echo "Sản phẩm đã được xóa thành công.";
        } else {
            echo "Sản phẩm không tồn tại trong giỏ hàng.";
        }
    }
} else {
    // Yêu cầu không hợp lệ
    echo "Yêu cầu không hợp lệ.";
}
?>
