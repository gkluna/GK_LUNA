<?php

function addToCartDB($MaNguoiDung, $MaSanPham, $MaBienThe, $SoLuong)
{

    $sql_check = "SELECT MaGioHang, SoLuong FROM giohang WHERE MaNguoiDung = '$MaNguoiDung' AND MaSanPham = '$MaSanPham' AND MaBienThe = '$MaBienThe' LIMIT 1";
    $check = pdo_query_one($sql_check);
    if ($check) {
        $SoLuongMoi = $check['SoLuong'] + $SoLuong;
        $sql_update = "UPDATE giohang SET SoLuong = '$SoLuongMoi' WHERE MaGioHang = '{$check['MaGioHang']}'";
        pdo_execute($sql_update);
    } else {
        $sql_insert = "INSERT INTO giohang (MaNguoiDung, MaSanPham, MaBienThe, SoLuong) VALUES ('$MaNguoiDung', '$MaSanPham', '$MaBienThe', '$SoLuong')";
        pdo_execute($sql_insert);
    }
}

function getCartItemsFromDB($MaNguoiDung)
{
    $sql = "SELECT g.MaGioHang, p.hinhAnh, g.MaSanPham as product_id, g.MaBienThe, g.SoLuong as userSelectedQuantity, p.tenSanPham, p.gia, b.size, b.color, b.quantity
            FROM giohang g
            JOIN sanpham p ON g.MaSanPham = p.id
            JOIN bienthesanpham b ON g.MaBienThe = b.MaBienThe
            WHERE g.MaNguoiDung = '$MaNguoiDung'";
    $items = pdo_query($sql);
    return ($items);
}
function updateProductQuantity($MaBienThe, $newQuantity, $userId)
{
    $sql = "UPDATE giohang SET SoLuong = '$newQuantity' WHERE MaBienThe = '$MaBienThe' and MaNguoiDung = '$userId'";
    return pdo_execute($sql);
}
function deleteProductFromCart($MaBienThe, $userId)
{
    $sql = "DELETE FROM giohang WHERE  MaBienThe = '$MaBienThe' and MaNguoiDung = '$userId'";
    pdo_execute($sql);
}

