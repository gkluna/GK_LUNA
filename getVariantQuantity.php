<?php
include 'model/pdo.php';
include 'model/sanpham.php';
include 'model/bienthesanpham.php';

$MaSanPham = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$color = isset($_GET['color']) ? $_GET['color'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';

$response = ['quantity' => 0, 'available' => false];

if ($MaSanPham > 0 && ($color !== '' || $size !== '')) {
    $quantity = getVariantQuantity($MaSanPham, $color, $size);
    // Kiểm tra xem $quantity có phải là số nguyên không
    if (is_numeric($quantity) && $quantity > 0) {
        $response['quantity'] = (int)$quantity;
        $response['available'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
