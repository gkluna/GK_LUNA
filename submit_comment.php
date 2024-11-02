<?php

session_start();
include "model/pdo.php";
include "model/comment.php";

header('Content-Type: application/json');

// Kiểm tra người dùng đã đăng nhập và gửi dữ liệu cần thiết chưa
if (!isset($_SESSION['user']) || !isset($_POST['comment']) || !isset($_POST['MaSanPham'])) {
    echo json_encode(['success' => false, 'error' => 'Bạn cần đăng nhập và nhập đầy đủ thông tin']);
    exit;
}

$MaSanPham = $_POST['MaSanPham'];
$comment = $_POST['comment'];
$MaNguoiDung = $_SESSION['user']['id_user']; // Giả sử MaNguoiDung được lưu trong session
$NgayTao = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại

try {
    // Insert bình luận vào cơ sở dữ liệu
    $sql = "INSERT INTO danhgia (MaSanPham, MaNguoiDung, BinhLuan, NgayTao) VALUES ('$MaSanPham', '$MaNguoiDung', '$comment', '$NgayTao')";
    pdo_execute($sql);

    // Lấy thông tin người dùng để hiển thị với bình luận mới
    $userData = pdo_query_one("SELECT hinhAnh, userName FROM nguoidung WHERE MaNguoiDung = ?", [$MaNguoiDung]);

    if ($userData) {
        echo json_encode([
            'success' => true,
            'userName' => $userData['userName'],
            'userImage' => "admin/upload/" . $userData['hinhAnh'],
            'createdAt' => $NgayTao,
            'comment' => htmlspecialchars($comment, ENT_QUOTES) // Mã hóa ký tự đặc biệt để tránh XSS
        ]);
    } else {
        throw new Exception("Không tìm thấy thông tin người dùng.");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
?>
