<?php
function check_user($userName)
{
    $sql = "SELECT COUNT(*) FROM nguoidung WHERE userName =" . $userName;
    $result = pdo_query_one($sql);
    return $result;
}

function insert_user($userName, $email, $pass, $fullname, $address, $tel)
{
    $sql = "INSERT INTO nguoidung(userName,email, pass, fullname, address, tel) 
        VALUES ('$userName','$email','$pass', '$fullname','$address','$tel')";
    pdo_execute($sql);
}

function update_user($id_user, $userName, $filename, $email, $pass, $fullname, $address, $tel, $role)
{
    if ($filename != "") {
        $sql = "update nguoidung 
            set userName='" . $userName . "', email='" . $email . "', pass='" . $pass . "', fullname='" . $fullname . "', address='" . $address . "', tel='" . $tel . "' , role='" . $role . "'  , hinhAnh='" . $filename . "' 
            where id_user=" . $id_user;
    } else {
        $sql = "update nguoidung 
            set userName='" . $userName . "', email='" . $email . "', pass='" . $pass . "', fullname='" . $fullname . "', address='" . $address . "', tel='" . $tel . "', role='" . $role . "'
            where id_user=" . $id_user;
    }
    pdo_execute($sql);
}

function getTotalUser()
{
    $sql = "SELECT COUNT(*) as total FROM nguoidung";
    $result = pdo_query_one($sql);
    return $result['total'];
}

function loadAll_users($limit = 9, $offset = 0)
{
    $limit = (int)$limit;
    $offset = (int)$offset;
    $sql = "SELECT * FROM nguoidung ORDER BY id_user DESC LIMIT $limit OFFSET $offset";
    $listaikhoan = pdo_query($sql);
    return $listaikhoan;
}
function delete_User($id_user)
{
    $sql = "DELETE FROM nguoidung WHERE id_user= '$id_user' and role = 'nguoidung'";
    pdo_query($sql);
}
function loadOne_user($id_user)
{
    $sql = "select * from nguoidung where id_user =" . $id_user;
    $user = pdo_query_one($sql);
    return $user;
}

function checkLogin($email, $pass)
{
    $sql = "select * from nguoidung where email= '" . $email . "' and pass = '" . $pass . "' AND role = 'quantri'";
    $user = pdo_query_one($sql);
    return $user;
}

function checkUser($email, $pass)
{
    $sql = "select * from nguoidung where email= '" . $email . "' and pass = '" . $pass . "'";
    $tk = pdo_query_one($sql);
    return $tk;
}
function sendMail($email)
{
    $sql = "SELECT * FROM nguoidung WHERE email = '" . $email . "'";
    $taikhoan = pdo_query_one($sql);

    if ($taikhoan != false) {
        sendMailPass($email, $taikhoan['userName'], $taikhoan['pass']);
        return "Gủi mail thành công";
    } else {
        return "Email bạn nhập ko có trong hệ thống ";
    }
}
function sendMailPass($email, $userName, $pass)
{

    require './admin/PHPMailer/src/Exception.php';
    require './admin/PHPMailer/src/PHPMailer.php';
    require './admin/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '1490350edd83df';                     //SMTP username
        $mail->Password   = 'a070494c66c1a5';                               //SMTP password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('duan1@example.com', 'DuAN1');
        $mail->addAddress($email, $userName);     //Add a recipient               //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Nguoi dung quen mat khau';
        $mail->Body    = 'Mat khau cua ban la:' . $pass;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function checkUserName($userName)
{
    $sql = "SELECT COUNT(*) as userCount FROM nguoidung WHERE userName = '$userName'";
    $result = pdo_query_one($sql);
    return $result['userCount'] > 0;
}
function checkEmail($email)
{
    $sql = "SELECT COUNT(*) as userEmail FROM nguoidung WHERE email = '$email'";
    $result = pdo_query_one($sql);
    return $result['userEmail'] > 0;
}
function PassValid($password)
{
    // Yêu cầu mật khẩu từ 6-12 ký tự, ít nhất 1 số và 1 ký tự đặc biệt.
    return preg_match('/^(?=.*\d)(?=.*[\W_]).{6,12}$/', $password);
}

function totalUsers()
{
    $sql = "SELECT COUNT(*) as total FROM nguoidung WHERE role != 'quantri'";
    $result = pdo_query_one($sql);
    return $result['total'];
}
function profile($id_user)
{
    $sql = "SELECT * FROM nguoidung where id_user = '$id_user'";
    return pdo_query($sql);
}

function detailOrder1($id_user)
{
    $sql = "SELECT n.fullname,n.address,n.tel ,s.tenSanpham,s.hinhAnh,s.gia, bt.size,bt.color,ct.SoLuong,dh.TongGia
            FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
            JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
            JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
            JOIN sanpham as s on bt.MaSanPham = s.id
            WHERE MaNguoiDung = '$id_user'";
    return pdo_query($sql);
}

function getTotal3($id_user)
{
    $sql = "SELECT COUNT(*) as total FROM `donhang` WHERE MaNguoiDung = '$id_user' AND TrangThai = 'huydon'";
    $result = pdo_query_one($sql);
    return $result['total'];
}
function detailOrder3()
{
    $sql = "SELECT n.fullname,n.address,n.tel ,s.tenSanpham,s.hinhAnh,s.gia, bt.size,bt.color,ct.SoLuong,dh.TongGia
            FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
            JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
            JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
            JOIN sanpham as s on bt.MaSanPham = s.id
            WHERE dh.TrangThai = 'huydon'";
    return pdo_query($sql);
}
function getTotal4($id_user)
{
    $sql = "SELECT COUNT(*) as total FROM `donhang` WHERE MaNguoiDung = '$id_user' AND TrangThai = 'giaohangthanhcong'";
    $result = pdo_query_one($sql);
    return $result['total'];
}
function detailOrder4()
{
    $sql = "SELECT n.fullname,n.address,n.tel ,s.tenSanpham,s.hinhAnh,s.gia, bt.size,bt.color,ct.SoLuong,dh.TongGia
            FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
            JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
            JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
            JOIN sanpham as s on bt.MaSanPham = s.id
            WHERE dh.TrangThai = 'giaohangthanhcong'";
    return pdo_query($sql);
}
function getTotal2($id_user)
{
    $sql = "SELECT COUNT(*) as total FROM `donhang` WHERE MaNguoiDung = '$id_user' AND TrangThai != 'giaohangthanhcong' AND TrangThai != 'giaohangthatbai' AND TrangThai != 'huydon'";
    $result = pdo_query_one($sql);
    return $result['total'];
}

function detailOrder2($id_user)
{
    $sql = "SELECT * FROM donhang  WHERE MaNguoiDung = '$id_user' AND TrangThai != 'giaohangthanhcong' AND TrangThai != 'giaohangthatbai' AND TrangThai != 'huydon'";
    return pdo_query($sql);
}
function detailOrder5($status, $id_user){
    $sql = "SELECT * FROM donhang  WHERE MaNguoiDung = '$id_user' AND TrangThai = '$status'";
    return pdo_query($sql);
}














// function detailOrder5($status, $id_user)
// {
//     $sql = "SELECT n.*,dh.*,ct.*,s.*
//             FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
//             JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
//             JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
//             JOIN sanpham as s on bt.MaSanPham = s.id
//             WHERE MaNguoiDung = '$id_user' AND TrangThai = '$status'";
//     return pdo_query($sql);
// }
// // function detail($id_user)
// {
//     $sql = "SELECT n.*,dh.*,ct.*,s.*
//             FROM nguoidung as n join donhang as dh on n.id_user = dh.MaNguoiDung
//             JOIN chitietdonhang as ct on dh.MaDonHang = ct.MaDonHang
//             JOIN bienthesanpham as bt on ct.MaBienThe = bt.MaBienThe
//             JOIN sanpham as s on bt.MaSanPham = s.id
//             WHERE MaNguoiDung = '$id_user' AND TrangThai != 'giaohangthanhcong' AND TrangThai != 'giaohangthatbai' AND TrangThai != 'huydon'";
//     return pdo_query($sql);
// }