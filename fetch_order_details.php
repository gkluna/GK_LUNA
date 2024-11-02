<?php

include "model/pdo.php";
include "model/users.php";

// Lấy trạng thái từ yêu cầu AJAX
$id_user = $_POST['id_user'];
$status = $_POST['status'];

$orders = ($status === "new") ? detailOrder2($id_user) : detailOrder5($status, $id_user);

if (!empty($orders)) {
    // Bắt đầu bảng
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mã Đơn Hàng</th>";
    echo "<th>Tổng Giá</th>";
    echo "<th>Trạng Thái</th>";
    echo "<th>Hành Động</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($orders as $order) {
        // Dòng thông tin cho mỗi đơn hàng
        echo "<tr>";
        echo "<td>" . $order["MaDonHang"] . "</td>";
        echo "<td>" . number_format($order["TongGia"]) . " VND</td>";

        // Xử lý hiển thị trạng thái
        $displayStatus = "";
        switch ($order["TrangThai"]) {
            case "xacnhandon":
                $displayStatus = "Đơn hàng đang được chuẩn bị";
                break;
            case "giaohang":
                $displayStatus = "Đơn hàng đang được giao";
                break;
            default:
                $displayStatus = $order["TrangThai"];
        }
        echo "<td>" . $displayStatus . "</td>";

        // Hành động: Nếu trạng thái là 'choxuly', hiển thị nút 'Hủy'
        $actionButtons = "<button class='btn btn-info btn-sm view-detail' data-id='" . $order["MaDonHang"] . "'>Xem Chi Tiết</button>";
        if ($order["TrangThai"] == "choxuly") {
            $actionButtons .= " <button class='btn btn-danger btn-sm cancel-order' data-id='" . $order["MaDonHang"] . "'>Hủy</button>";
        }
        echo "<td>" . $actionButtons . "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "Không có đơn hàng nào.";
}

?>
