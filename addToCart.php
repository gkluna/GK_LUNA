<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

include "model/pdo.php"; 
include "model/cart.php"; 
include "model/bienthesanpham.php";

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $userSelectedQuantity = $_POST['userSelectedQuantity'];

    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        $maBienThe = getVariantIdForProduct($productId, $color, $size);

        // Nếu không tìm thấy mã biến thể, có thể xử lý tùy ý (ví dụ: báo lỗi, tạo biến thể mới, v.v.)
        if (null === $maBienThe) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy biến thể sản phẩm.']);
            exit;
        }

        // Gọi hàm lưu thông tin vào CSDL
        addToCartDB($userId, $productId, $maBienThe, $userSelectedQuantity);
        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
    } else {
        // Xử lý cho trường hợp người dùng không đăng nhập, lưu vào session
        $isFound = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $productId && $item['color'] == $color && $item['size'] == $size) {
                $item['userSelectedQuantity'] += $userSelectedQuantity;
                $isFound = true;
                break;
            }
        }

        if (!$isFound) {
            $_SESSION['cart'][] = [
                'product_id' => $productId,
                'color' => $color,
                'size' => $size,
                'userSelectedQuantity' => $userSelectedQuantity
            ];
        }

        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng tạm thời.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Thông tin sản phẩm không hợp lệ.']);
}
