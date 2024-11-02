<?php

function themHoacCapNhatBienThe($MaSanPham, $color, $size, $quantity)
{
    // Kiểm tra xem biến thể đã tồn tại chưa
    $sqlKiemTra = "SELECT * FROM bienthesanpham WHERE MaSanPham = '$MaSanPham' AND color = '$color' AND size = '$size'";
    $kiemTraResult = pdo_query($sqlKiemTra);

    if (count($kiemTraResult) > 0) {
        // Nếu biến thể tồn tại, cập nhật số lượng
        $existingVariant = $kiemTraResult[0]; // Giả sử rằng hàm pdo_query trả về một mảng các dòng từ CSDL
        $newQuantity = $existingVariant['quantity'] + $quantity;
        $sqlCapNhat = "UPDATE bienthesanpham SET quantity = '$newQuantity' WHERE MaSanPham = '$MaSanPham' AND color = '$color' AND size = '$size'";
        pdo_execute($sqlCapNhat);
    } else {
        // Nếu biến thể không tồn tại, thêm mới
        $sqlThem = "INSERT INTO bienthesanpham (MaSanPham, color, size, quantity) VALUES ('$MaSanPham', '$color', '$size', '$quantity')";
        pdo_execute($sqlThem);
    }
}
function update_bienthe($MaBienThe,$color, $size, $quantity)
{

    $sql = "UPDATE bienthesanpham SET  color='$color', size='$size', quantity='$quantity' WHERE MaBienThe='$MaBienThe'";
    pdo_execute($sql);
}

function softdelete_bienthe($MaBienThe)
{
    // Lấy danh sách các đơn hàng chứa biến thể này và đang trong trạng thái "chờ xử lý"
    $sql = "SELECT DISTINCT chitietdonhang.MaDonHang FROM chitietdonhang 
            JOIN donhang ON chitietdonhang.MaDonHang = donhang.MaDonHang
            WHERE MaBienThe = ? AND donhang.TrangThai = 'choxuly'";
    $cacDonHang = pdo_query($sql, $MaBienThe);

    foreach ($cacDonHang as $donHang) {
        $sqlDem = "SELECT COUNT(*) AS SoLuong FROM chitietdonhang WHERE MaDonHang = ?";
        $ketQua = pdo_query_one($sqlDem, $donHang['MaDonHang']);

        if ($ketQua && $ketQua['SoLuong'] == 1) {
            // Nếu đơn hàng chỉ có một biến thể, cập nhật trạng thái thành "hủy đơn"
            $sqlCapNhat = "UPDATE donhang SET TrangThai = 'huydon' WHERE MaDonHang = ?";
            pdo_execute($sqlCapNhat, $donHang['MaDonHang']);
        } elseif ($ketQua && $ketQua['SoLuong'] > 1) {
            // Nếu đơn hàng có nhiều hơn một biến thể hoặc sản phẩm, xóa biến thể này khỏi đơn hàng
            $sqlXoaBienThe = "DELETE FROM chitietdonhang WHERE MaBienThe = ? AND MaDonHang = ?";
            pdo_execute($sqlXoaBienThe, $MaBienThe, $donHang['MaDonHang']);
        }
    }

    // Cập nhật trạng thái của biến thể thành không hoạt động
    $sqlXoaMem = "UPDATE bienthesanpham SET isActive = FALSE WHERE MaBienThe = ?";
    pdo_execute($sqlXoaMem, $MaBienThe);
}



function loadAll_bienthe_sanpham()
{
    $sql = "SELECT sp.id, sp.tenSanPham, bt.color, bt.size, SUM(bt.quantity) as total
    FROM sanpham sp 
    INNER JOIN bienthesanpham bt ON sp.id = bt.MaSanPham
    GROUP BY sp.id, bt.color, bt.size
    ORDER BY sp.tenSanPham, bt.color, bt.size;";
    return pdo_query($sql);
}


// Lấy thông tin một biến thể cụ thể
function loadOne_bienthe($MaBienThe)
{
    $sql = "SELECT * FROM bienthesanpham WHERE isActive = '1' and MaBienThe=" . $MaBienThe;
    return pdo_query_one($sql);
}
function getTotalVariant($MaSanPham) {
    $sql = "SELECT COUNT(*) as total FROM bienthesanpham where isActive = '1' and MaSanPham=".$MaSanPham;
    $result = pdo_query_one($sql);
    return $result['total'];
}
function get_variant($MaSanPham ,$limit = 9, $offset = 0) {
    
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT * FROM bienthesanpham WHERE isActive = '1' and MaSanPham = '$MaSanPham' ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $list_variant = pdo_query($sql);
    return $list_variant;
}
function get_total_variants($MaSanPham) {
    $sql = "SELECT COUNT(*) as total FROM bienthesanpham WHERE MaSanPham = '$MaSanPham'";
    $result = pdo_query_one($sql);
    return $result['total'];
}

function loadOne_bienthe_sanpham($MaSanPham, $limit = 9, $offset = 0)
{
   
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT bt.* , sp.tenSanPham
            FROM bienthesanpham bt 
            INNER JOIN sanpham sp ON sp.id = bt.MaSanPham
            WHERE bt.isActive = '1' and bt.MaSanPham = '$MaSanPham'
            LIMIT $limit OFFSET $offset";
     $list_variant = pdo_query($sql);
     return $list_variant;
}

function getVariantIdForProduct($MaSanPham, $color, $size) {
    $sql = "SELECT MaBienThe FROM bienthesanpham WHERE MaSanPham = '$MaSanPham' AND color = '$color' AND size = '$size' LIMIT 1";
    $result = pdo_query_one($sql);
    if (!empty($result)) {
        return $result['MaBienThe'];
    } else {
        return null;
    }
}
function getIdForProduct($MaBienThe, $color, $size) {
    $sql = "SELECT MaSanPham FROM bienthesanpham WHERE MaBienThe = '$MaBienThe' AND color = '$color' AND size = '$size' LIMIT 1";
    $result = pdo_query_one($sql);
    if (!empty($result)) {
        return $result['MaSanPham'];
    } else {
        return null;
    }
}
function updateQuantity($variantId, $quantity){
    $sql = "SELECT quantity FROM bienthesanpham where MaBienThe = '$variantId'";
    $result = pdo_query_one($sql);
   
    if ($result) {
        $currentQuantity = $result['quantity'];
        $newQuantity = $currentQuantity - $quantity;
         if ($newQuantity <0) {
            return false;
         }
         $sqlUpdate = "UPDATE bienthesanpham set quantity = '$newQuantity' where MaBienThe = '$variantId'";
         pdo_execute($sqlUpdate);
         return true; // Cập nhật thành công     
    } else {
        return false;
    }
}

