<?php


require_once 'model/pdo.php'; // Đường dẫn đến file kết nối cơ sở dữ liệu của bạn
require_once 'model/cart.php'; // Đường dẫn đến file chứa hàm cập nhật số lượng sản phẩm trong giỏ hàng

// Kiểm tra yêu cầu POST và dữ liệu cần thiết
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaBienThe'], $_POST['newQuantity'])) {
    $MaBienThe = $_POST['MaBienThe'];
    $newQuantity = (int)$_POST['newQuantity'];
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Cập nhật số lượng sản phẩm trong giỏ hàng trong cơ sở dữ liệu
        if (updateProductQuantity($MaBienThe, $newQuantity, $userId)) {
            echo json_encode(['success' => true, 'message' => 'Số lượng sản phẩm đã được cập nhật.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật số lượng sản phẩm.']);
        }
    } else {
        // Người dùng chưa đăng nhập, cập nhật số lượng sản phẩm trong session
        if (isset($_SESSION['cart'][$MaBienThe])) {
            $_SESSION['cart'][$MaBienThe]['quantity'] = $newQuantity;
            echo json_encode(['success' => true, 'message' => 'Số lượng sản phẩm đã được cập nhật trong giỏ hàng tạm thời.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
        }
    }
} else {
    // Yêu cầu không hợp lệ
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ.']);
}
?>
