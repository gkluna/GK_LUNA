
<?php
include "model/pdo.php";
include "model/donhang.php"; // Giả sử bạn có file model này

$id_order = $_POST['id'];


$orderDetail = detailOrder($id_order); 

$html = '<div class="order-details">';
foreach ($orderDetail as $detail) {
    $html .= '<div class="product-detail">';
    $html .= '<img src="admin/upload/' . $detail['hinhAnh'] . '" alt="' . $detail['tenSanPham'] . '" style="width:100px;height:auto;">';
    $html .= '<p>Tên sản phẩm: ' . $detail['tenSanPham'] . '</p>';
    $html .= '<p>Số lượng: ' . $detail['SoLuong'] . '</p>';
    $html .= '<p>Màu sắc: ' . $detail['color'] . '</p>';
    $html .= '<p>Kích cỡ: ' . $detail['size'] . '</p>';
    $html .= '<p>Giá: ' . number_format($detail['gia']) . ' VND</p>';
    $html .= '<p>Tổng giá: ' . number_format($detail['TongGia']) . ' VND</p>';
    $html .= '</div>';
}
$html .= '</div>';

echo $html;

