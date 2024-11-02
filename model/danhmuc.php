<?php


function insert_danhmuc($TenDanhMuc)
{
    $sql = "INSERT INTO DanhMuc(TenDanhMuc) VALUES ('$TenDanhMuc')";
    pdo_execute($sql);
}
function tenDanhMucDaTonTai($TenDanhMuc, $id = 0)
{
    $danhMucs = loadAll_danhmuc();
    foreach ($danhMucs as $dm) {
        // Chuyển đổi cả hai tên danh mục về chữ thường trước khi so sánh
        if (strtolower($dm['TenDanhMuc']) === strtolower($TenDanhMuc) && $dm['id'] != $id) {
            return true;
        }
    }
    return false;
}

function delete_danhmuc($id)
{
    $sql = "DELETE FROM DanhMuc WHERE id =".$id;
    pdo_execute($sql);
}

function loadAll_danhmuc()
{
    $sql = "SELECT * FROM DanhMuc ORDER BY id DESC";
    $listdm = pdo_query($sql);
    return $listdm;
}
function getTotalDanhMuc() {
    $sql = "SELECT COUNT(*) as total FROM DanhMuc";
    $result = pdo_query_one($sql);
    return $result['total'];
}
function get_danhmuc($limit = 9, $offset = 0) {
    
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT * FROM DanhMuc ORDER BY id DESC  LIMIT $limit OFFSET $offset";
    $list_dm = pdo_query($sql);
    return $list_dm;
}

function loadOne_danhmuc($id)
{
    $sql = "SELECT * FROM DanhMuc WHERE id =".$id;
    $dm = pdo_query_one($sql);
    return $dm;
}

function update_danhmuc($id, $TenDanhMuc)
{
    $sql = "UPDATE DanhMuc SET TenDanhMuc = '".$TenDanhMuc."' WHERE id =".$id;
    pdo_execute($sql);
}
?>