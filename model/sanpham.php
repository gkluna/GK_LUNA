<?php

function insert_sanpham($tenSanPham, $moTa, $gia, $iddm, $filename)
{
    $sql = "INSERT INTO sanpham(tenSanPham, moTa, gia, iddm, hinhAnh) VALUES ('$tenSanPham' , '$moTa' , '$gia' , '$iddm', '$filename')";
    pdo_execute($sql);
}

function update_dmsp($iddm)
{
    $sql = "UPDATE sanpham set iddm ='21' WHERE iddm = '$iddm'";
    pdo_execute($sql);
}

function update_sanpham($id, $tenSanPham, $moTa, $gia, $filename, $iddm)
{
    if ($filename != "") {
        $sql = "UPDATE sanpham SET iddm = '$iddm', tenSanPham = '$tenSanPham', moTa = '$moTa', gia = '$gia', hinhAnh = '$filename' WHERE id = " . $id;
    } else {
        $sql = "UPDATE sanpham SET iddm = '$iddm', tenSanPham = '$tenSanPham', moTa = '$moTa', gia = '$gia' WHERE id = " . $id;
    }
    pdo_execute($sql);
}


function adjust_order_status_before_sanpham_delete($MaSanPham)
{
    // Lấy danh sách đơn hàng chứa sản phẩm này và đang ở trạng thái chờ xử lý
    $sql = "SELECT DISTINCT chitietdonhang.MaDonHang FROM chitietdonhang 
    JOIN donhang ON chitietdonhang.MaDonHang = donhang.MaDonHang
    WHERE MaSanPham = ? AND donhang.TrangThai = 'choxuly'";
    $orders = pdo_query($sql, $MaSanPham);

    foreach ($orders as $order) {
        $sqlCount = "SELECT COUNT(*) AS Count FROM chitietdonhang WHERE MaDonHang = ?";
        $result = pdo_query_one($sqlCount, $order['MaDonHang']);

        if ($result && $result['Count'] == 1) {
            $sqlUpdate = "UPDATE donhang SET TrangThai = 'huydon' WHERE MaDonHang = ?";
            pdo_execute($sqlUpdate, $order['MaDonHang']);
        } elseif ($result && $result['Count'] > 1) {
            $sqlRemoveProduct = "DELETE FROM chitietdonhang WHERE MaSanPham = ? AND MaDonHang = ?";
            pdo_execute($sqlRemoveProduct, $MaSanPham, $order['MaDonHang']);
        }
    }

    $sqlSoftDelete = "UPDATE sanpham SET isActive = FALSE WHERE id = ?";
    pdo_execute($sqlSoftDelete, $MaSanPham);
}


function getTotalSanPham()
{
    $sql = "SELECT COUNT(*) as total FROM sanpham";
    $result = pdo_query_one($sql);
    return $result['total'];
}

function loadAll_sanpham($limit = 9, $offset = 0)
{
    $limit = (int)$limit;
    $offset = (int)$offset;

    // Cập nhật câu truy vấn để chỉ tính tổng số lượng từ những biến thể sản phẩm còn hoạt động
    $sql = "SELECT sp.*, dm.TenDanhMuc, COALESCE(SUM(CASE WHEN bt.isActive = '1' THEN bt.quantity ELSE 0 END), 0) AS tongSoLuong
    FROM sanpham AS sp
    JOIN danhmuc AS dm ON sp.iddm = dm.id
    LEFT JOIN bienthesanpham AS bt ON sp.id = bt.MaSanPham
    WHERE sp.isActive = '1'
    GROUP BY sp.id, dm.TenDanhMuc
    LIMIT $limit OFFSET $offset";

    return pdo_query($sql);
}



function getVariantQuantity($MaSanPham, $color, $size)
{
    $sql = "SELECT quantity FROM bienthesanpham WHERE MaSanPham = '$MaSanPham' AND color = '$color' AND size = '$size'";
    $result = pdo_query_one($sql);
    if ($result) {
        return (int) $result['quantity'];
    } else {
        return 0;
    }
}


function loadOne_sanpham($id)
{
    $sql = "SELECT sp.*, COALESCE(SUM(bt.quantity), 0) AS tongSoLuong
    FROM sanpham AS sp
    JOIN danhmuc AS dm ON sp.iddm = dm.id
    LEFT JOIN bienthesanpham AS bt ON sp.id = bt.MaSanPham
    WHERE sp.id = '$id'
    GROUP BY sp.id";
    return pdo_query_one($sql);
}


function loadOne_sanpham_cungloai($id, $iddm)
{
    $sql = "select * from sanpham where iddm=" . $iddm . " and id<>" . $id;
    $listsanpham = pdo_query($sql);

    return $listsanpham;
}


//Lọc

function getAllCategories()
{

    $sql = "SELECT * FROM danhmuc ORDER BY TenDanhMuc ASC";
    return pdo_query($sql);
}

// Hàm lấy sản phẩm theo điều kiện
function getProducts($conditions = [], $priceRange = '', $priceSort = '')
{
    $sql = "SELECT * FROM sanpham WHERE 1";

    // Thêm điều kiện cho danh mục
    if (!empty($conditions)) {
        $sql .= " AND iddm IN (" . implode(',', $conditions) . ")";
    }

    // Thêm điều kiện cho khoảng giá
    if ($priceRange) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        $sql .= " AND gia BETWEEN $minPrice AND $maxPrice";
    }

    // Thêm điều kiện sắp xếp giá
    if ($priceSort) {
        $sql .= " ORDER BY gia $priceSort";
    } else {
        // Mặc định sắp xếp theo ngày tạo nếu không có điều kiện sắp xếp giá
        $sql .= " ORDER BY NgayTao DESC";
    }

    return pdo_query($sql);
}
function getTotalSanPhamFiltered($categoriesFilter, $priceRange)
{
    $sql = "SELECT COUNT(*) FROM sanpham WHERE isActive = '1' and 1=1";

    if (!empty($categoriesFilter)) {
        $sql .= " AND iddm IN (" . implode(',', $categoriesFilter) . ")";
    }

    if (!empty($priceRange) && strpos($priceRange, '-') !== false) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        $sql .= " AND gia BETWEEN $minPrice AND $maxPrice";
    }

    $totalRecords = pdo_query_value($sql);
    return $totalRecords;
}

function getProductsFiltered($categoriesFilter, $priceRange, $priceSort, $limit, $offset)
{
    $sql = "SELECT * FROM sanpham WHERE isActive = '1' and 1=1";

    if (!empty($categoriesFilter)) {
        $sql .= " AND iddm IN (" . implode(',', $categoriesFilter) . ")";
    }

    if (!empty($priceRange) && strpos($priceRange, '-') !== false) {
        list($minPrice, $maxPrice) = explode('-', $priceRange);
        $sql .= " AND gia BETWEEN $minPrice AND $maxPrice";
    }

    // Đảm bảo chỉ cho phép sắp xếp theo 'ASC' hoặc 'DESC'
    $allowedSorts = ['ASC', 'DESC'];
    if (!empty($priceSort) && in_array($priceSort, $allowedSorts)) {
        $sql .= " ORDER BY gia $priceSort";
    } else {
        $sql .= " ORDER BY NgayTao DESC"; // Sắp xếp mặc định theo ngày tạo
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    return pdo_query($sql);
}

function totalSearch($keyword)
{
    $sql = "SELECT COUNT(*) as total FROM sanpham
            INNER JOIN danhmuc ON sanpham.iddm = danhmuc.id
            WHERE sanpham.tenSanPham LIKE '%" . $keyword . "%' OR danhmuc.TenDanhMuc LIKE  '%" . $keyword . "%' OR sanpham.moTa LIKE  '%" . $keyword . "%'";
    $result = pdo_query_one($sql);
    return $result['total'];
}


function getSearchResult($keyword, $limit = 6, $offset = 0)
{

    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT sanpham.*, danhmuc.TenDanhMuc FROM sanpham
            INNER JOIN danhmuc ON sanpham.iddm = danhmuc.id
            WHERE sanpham.isActive = '1' and sanpham.tenSanPham LIKE '%" . $keyword . "%' OR danhmuc.TenDanhMuc LIKE  '%" . $keyword . "%' OR sanpham.moTa LIKE  '%" . $keyword . "%'
            LIMIT $limit OFFSET $offset";
    $search = pdo_query($sql);
    return $search;
}
function getProductDetailsById($productId, $color, $size)
{
    $sql = "SELECT sp.id, sp.tenSanPham, sp.hinhAnh, sp.moTa, sp.gia, bsp.size, bsp.color, bsp.quantity 
            FROM sanpham AS sp
            JOIN bienthesanpham AS bsp ON sp.id = bsp.MaSanPham
            WHERE sp.id = '$productId' AND bsp.color = '$color' AND bsp.size = '$size'";
    $productDetails = pdo_query_one($sql);

    return $productDetails;
}

function sellingHome()
{
    $sql = "SELECT sanpham.*, SUM(chitietdonhang.SoLuong) AS TongSoLuongBan
    FROM chitietdonhang
    JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id
    WHERE isActive = '1' and MONTH(chitietdonhang.NgayTao) = 4 AND YEAR(chitietdonhang.NgayTao) = 2024
    GROUP BY chitietdonhang.MaSanPham
    ORDER BY TongSoLuongBan DESC
    LIMIT 4;";
    $productSellings = pdo_query($sql);

    return $productSellings;
}
function newProduct()
{
    $sql = "SELECT * FROM sanpham  WHERE isActive = '1' ORDER BY NgayTao DESC LIMIT 5";
    $new = pdo_query($sql);
    return $new;
}

function filter_product($limit, $offset, $keyword = '', $iddm = ''){
    $sql = "SELECT sp.*, dm.TenDanhMuc, COALESCE(SUM(CASE WHEN bt.isActive = '1' THEN bt.quantity ELSE 0 END), 0) AS tongSoLuong
    FROM sanpham AS sp
    JOIN danhmuc AS dm ON sp.iddm = dm.id
    LEFT JOIN bienthesanpham AS bt ON sp.id = bt.MaSanPham
    WHERE sp.isActive = '1'  and 1=1";
    if (!empty($keyword)) {
        $sql .= " AND tenSanPham LIKE '%". $keyword ."%'";
    }
    if (!empty($iddm)) {
        $sql .= " AND iddm = $iddm";
    }
    $sql .= " GROUP BY sp.id, dm.TenDanhMuc";
    $sql .= " LIMIT $limit OFFSET $offset";
    return pdo_query($sql);
}
function getTotalProductFiltered($keyword='', $iddm=''){
    $sql = "SELECT COUNT(*) as total FROM sanpham WHERE 1=1";
    if ($keyword) {
        $sql .= " AND tenSanPham LIKE '%". $keyword ."%'";
    }
    if ($iddm) {
        $sql .= " AND iddm = $iddm";
    }
    $result = pdo_query_one($sql);
    return $result['total'];
}
