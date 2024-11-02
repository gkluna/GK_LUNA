<?php 
function donhang($user_id, $total){
    $sql = "INSERT INTO donhang(MaNguoiDung,TongGia) VALUES ('$user_id','$total')";
    $lastId = pdo_execute($sql);
    return $lastId;
}

function insertDetail($MaDonHang,$MaSanPham,$MaBienThe,$soLuong,$gia){
    $sql = "INSERT INTO chitietdonhang(MaDonHang, MaSanPham, MaBienThe, SoLuong,GiaLucMua) VALUES ('$MaDonHang','$MaSanPham','$MaBienThe','$soLuong','$gia')";
    pdo_execute($sql);
}

function getTotalOrders() {
    $sql = "SELECT COUNT(*) as total FROM donhang";
    $result = pdo_query_one($sql);
    return $result['total'];
}
function loadAll_orders($limit = 9, $offset = 0) {
    
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT dh.*, nd.fullName FROM donhang as dh join nguoidung as nd on dh.MaNguoiDung = nd.id_user ORDER BY MaDonHang DESC  LIMIT $limit OFFSET $offset";
    $list_order = pdo_query($sql);
    return $list_order;
}

function detailOrder($MaDonHang) 
{
    $sql = "SELECT n.fullname,n.address,n.tel ,s.tenSanPham,s.hinhAnh,s.gia, bt.size,bt.color,ct.SoLuong,dh.TongGia
            FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
            JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
            JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
            JOIN sanpham as s on bt.MaSanPham = s.id
            WHERE  dh.MaDonHang = '$MaDonHang'";
            return pdo_query($sql);

}

// function filterOrder($orderStatus, $priceRange, $dateRange, $priceSort, $limit, $offset) {
//     $sql = "SELECT dh.* , nd.fullName FROM donhang as dh join nguoidung as nd on dh.MaNguoiDung = nd.id_user WHERE 1";

//     if (!empty($orderStatus)) {
//             $sql .= " AND TrangThai = '$orderStatus'";
//     } else {
//         // Khi không lọc theo trạng thái hoặc trạng thái không phải là "ẩn", loại bỏ đơn hàng có trạng thái "ẩn"
//         $sql .= " AND TrangThai != 'ẩn'";
//     }
//     if ($priceRange) {
//         list($minPrice, $maxPrice) = explode('-', $priceRange);
//         $sql .= " AND TongGia BETWEEN $minPrice AND $maxPrice";
//     }
//     if ($dateRange) {
//         list($startDate, $endDate) = explode('to', $dateRange);
//         $sql .= " AND dh.NgayTao BETWEEN '$startDate' AND '$endDate'";
//     }
//     if ($priceSort) {
//         $sql .= " ORDER BY TongGia $priceSort";
//     } else {
//         $sql .= " ORDER BY NgayTao DESC";
//     }
//     $sql .= " LIMIT $limit OFFSET $offset";

//     return pdo_query($sql);
// }

// function getTotalFilteredOrders($orderStatus, $priceRange, $dateRange) {
//     $sql = "SELECT COUNT(*) FROM donhang WHERE 1";

//     if (!empty($orderStatus)) {
//             $sql .= " AND TrangThai = '$orderStatus'";
//     } 
//     if ($priceRange) {
//         list($minPrice, $maxPrice) = explode('-', $priceRange);
//         $sql .= " AND TongGia BETWEEN $minPrice AND $maxPrice";
//     }
//     if ($dateRange) {
//         list($startDate, $endDate) = explode('to', $dateRange);
//         $sql .= " AND NgayTao BETWEEN '$startDate' AND '$endDate'";
//     }

//     return pdo_query_value($sql); // Giả định hàm này thực thi SQL và trả về giá trị duy nhất
// }
function filterOrder($orderStatus, $priceRange, $dateRange, $searchKeyword, $limit, $offset) {
    $sql = "SELECT dh.*, nd.fullName FROM sanpham join bienthesanpham on sanpham.id = bienthesanpham.MaSanPham
            JOIN chitietdonhang on bienthesanpham.MaBienThe = chitietdonhang.MaBienThe
            JOIN donhang AS dh on chitietdonhang.MaDonHang = dh.MaDonHang
            JOIN nguoidung AS nd ON dh.MaNguoiDung = nd.id_user WHERE 1";

    if (!empty($orderStatus)) {
        $sql .= " AND dh.TrangThai = '$orderStatus'";
    } else {
        $sql .= " AND dh.TrangThai != 'ẩn'";
    }

    if ($priceRange) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        $sql .= " AND dh.TongGia BETWEEN $minPrice AND $maxPrice";
    }

    if ($dateRange) {
        list($startDate, $endDate) = explode('to', $dateRange);
        $sql .= " AND dh.NgayTao BETWEEN '$startDate' AND '$endDate'";
    }

    if (!empty($searchKeyword)) {
        $sql .= " AND (sanpham.tenSanPham LIKE '%$searchKeyword%' OR nd.fullName LIKE '%$searchKeyword%')";
    }

    $sql .= " ORDER BY dh.NgayTao DESC";
    $sql .= " LIMIT $limit OFFSET $offset";

    return pdo_query($sql);
}
function getTotalFilteredOrders($orderStatus, $priceRange, $dateRange, $searchKeyword) {
    $sql = "SELECT COUNT(*) FROM sanpham join bienthesanpham on sanpham.id = bienthesanpham.MaSanPham
    JOIN chitietdonhang on bienthesanpham.MaBienThe = chitietdonhang.MaBienThe
    JOIN donhang AS dh on chitietdonhang.MaDonHang = dh.MaDonHang
    JOIN nguoidung AS nd ON dh.MaNguoiDung = nd.id_user WHERE 1";

    if (!empty($orderStatus)) {
        $sql .= " AND dh.TrangThai = '$orderStatus'";
    }

    if ($priceRange) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        $sql .= " AND dh.TongGia BETWEEN $minPrice AND $maxPrice";
    }

    if ($dateRange) {
        list($startDate, $endDate) = explode('to', $dateRange);
        $sql .= " AND dh.NgayTao BETWEEN '$startDate' AND '$endDate'";
    }

    if (!empty($searchKeyword)) {
        $sql .= " AND (sanpham.tenSanPham LIKE '%$searchKeyword%' OR nd.fullName LIKE '%$searchKeyword%')";
    }

    return pdo_query_value($sql); // Giả định hàm này thực thi SQL và trả về giá trị duy nhất
}

function getCurrentStatus($MaDonHang){
    $sql = "SELECT TrangThai FROM donhang Where MaDonHang = '$MaDonHang'";
    return pdo_query($sql);
}

function updateOrderStatus($MaDonHang, $newStatus){
    $sql = "UPDATE donhang SET TrangThai = '$newStatus' WHERE MaDonHang = '$MaDonHang'";
    pdo_execute($sql);
}

function cancelOrderById($id_order){
    $sql = "UPDATE donhang set TrangThai = 'huydon' WHERE MaDonHang = '$id_order'";
    return pdo_execute($sql);
}
?>
