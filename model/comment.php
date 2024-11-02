<?php
function insert_commnent($comment, $iduser, $productId)
{
    $sql = "INSERT INTO danhgia(BinhLuan,MaNguoiDung,MaSanPham) values('$comment','$iduser','$productId')";
    pdo_execute($sql);
}

function loadAll_comment($productId)
{
    $sql = "SELECT dg.*, nd.userName, nd.hinhAnh FROM danhgia AS dg JOIN nguoidung AS nd ON dg.MaNguoiDung = nd.id_user WHERE 1";
    if ($productId > 0) {
        $sql .= " AND MaSanPham = '" . (int)$productId . "'";
    }
    $sql .= " ORDER BY NgayTao DESC";
    $listComment = pdo_query($sql);
    return $listComment;
}


function delete_comment($MaDanhgia)
{
    $sql = "delete from danhgia where MaDanhGia=" . $MaDanhgia;
    pdo_execute($sql);
}
function getTotalComment()
{
    $sql = "SELECT COUNT(*) as total FROM danhgia";
    $result = pdo_query_one($sql);
    return $result['total'];
}

function allComment($limit = 9, $offset = 0)
{
    $limit = (int)$limit;
    $offset = (int)$offset;

    // Cập nhật câu truy vấn để chỉ tính tổng số lượng từ những biến thể sản phẩm còn hoạt động
    $sql = "SELECT d.MaDanhGia, d.NgayTao, d.BinhLuan, n.fullName, s.tenSanPham 
        FROM nguoidung AS n 
        JOIN danhgia AS d ON n.id_user = d.MaNguoiDung
        JOIN sanpham AS s ON s.id = d.MaSanPham
        ORDER BY s.tenSanpham, d.NgayTao
        LIMIT $limit OFFSET $offset";
    return pdo_query($sql);
}
function filter_commnet($limit, $offset, $keyword = '')
{
    $sql = "SELECT d.MaDanhGia, d.NgayTao, d.BinhLuan, n.fullName, s.tenSanPham 
    FROM nguoidung AS n 
    JOIN danhgia AS d ON n.id_user = d.MaNguoiDung
    JOIN sanpham AS s ON s.id = d.MaSanPham
    WHERE 1=1";
    if (!empty($keyword)) {
        $sql .= " AND (s.tenSanPham LIKE '%" . $keyword . "%' OR n.fullName LIKE '%" . $keyword . "%')";
    }
    $sql .= " ORDER BY s.tenSanpham, d.NgayTao";
    $sql .= " LIMIT $limit OFFSET $offset";
    return pdo_query($sql);
}
function getTotalCommentFiltered($keyword = '')
{
    $sql = "SELECT COUNT(*) as total 
    FROM nguoidung AS n 
    JOIN danhgia AS d ON n.id_user = d.MaNguoiDung
    JOIN sanpham AS s ON s.id = d.MaSanPham
    WHERE 1=1";
    if (!empty($keyword)) {
        $sql .= " AND (s.tenSanPham LIKE '%" . $keyword . "%' OR n.fullName LIKE '%" . $keyword . "%')";
    }
    $sql .= " ORDER BY s.tenSanpham, d.NgayTao";
    $result = pdo_query_one($sql);
    return $result['total'];
}
