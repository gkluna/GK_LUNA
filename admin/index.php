<?php
session_start();
ob_start();
include "../model/pdo.php";
include "header.php";
include "../model/danhmuc.php";
include "../model/sanpham.php";
include "../model/bienthesanpham.php";
include "../model/donhang.php";
include "../model/thongke.php";
include "../model/users.php";
include "../model/comment.php";

if (!isset($_SESSION['admin']) || $_SESSION['role'] != 'quantri') {
    header("Location: login.php");
    exit(); // Dừng việc thực thi script hiện tại
}
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    switch ($act) {

            // Danh mục
        case 'adddm':
            if (isset($_POST['themmoi'])) {
                $tenDanhMuc = trim($_POST['TenDanhMuc']);
                $errors = [];

                if (empty($tenDanhMuc)) {
                    $errors['TenDanhMuc'] = 'Tên danh mục không được để trống!';
                } elseif (tenDanhMucDaTonTai($tenDanhMuc)) {
                    $errors['TenDanhMuc'] = 'Tên danh mục đã tồn tại!';
                }
                if (empty($errors)) {
                    insert_danhmuc($tenDanhMuc);
                    $thongbao = "Thêm mới thành công!";
                }
            }

            include "danhmuc/add.php";
            break;
        case 'listdm':
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;
            $totalDanhMuc = getTotalDanhMuc();
            $totalPages = ceil($totalDanhMuc / $limit);
            $list_dm = loadAll_danhmuc($limit = 9, $offset = 0);
            include "danhmuc/list.php";
            break;
        case 'xoadm':
            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                $iddm = $_GET['id'];
                update_dmsp($iddm);
                delete_danhmuc($_GET['id']);
            }
            header("Location: http://gk_luna.test/admin/index.php?act=listdm");
            break;
        case 'suadm':
            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                $dm = loadOne_danhmuc($_GET['id']);
            }
            include "danhmuc/update.php";
            break;
        case 'updatedm':
            if (isset($_POST['capnhat'])) {
                $tenDanhMuc = $_POST['TenDanhMuc'];
                $id = $_POST['id'];
                $errors = [];

                if (empty($tenDanhMuc)) {
                    $errors['TenDanhMuc'] = 'Tên danh mục không được để trống!';
                } elseif (tenDanhMucDaTonTai($tenDanhMuc, $id)) {
                    $errors['TenDanhMuc'] = 'Tên danh mục đã tồn tại!';
                }
                if (empty($errors)) {
                    update_danhmuc($id, $tenDanhMuc);
                    $thongbao = "Cập nhật thành công!";
                }

                include "danhmuc/update.php";
            }
            break;

            //SẢN PHẨM        

        case 'listsp':
            $danhMuc = loadAll_danhmuc();
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;

            if (isset($_POST['filter'])) {
                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
                $iddm = isset($_POST['danhMuc']) ? $_POST['danhMuc'] : null;
                $totalSanPham = getTotalProductFiltered($keyword, $iddm);
                $listsanpham = filter_product($limit, $offset, $keyword, $iddm);
            } else {
                $totalSanPham = getTotalSanPham();
                $listsanpham = loadAll_sanpham($limit, $offset);
            }

            $totalPages = ceil($totalSanPham / $limit);

            include "sanpham/list.php";
            break;


        case 'addsp':
            $errors = [];
            $thongbao = "";

            if (isset($_POST['themmoi']) && $_POST['themmoi']) {
                $tenSanPham = trim($_POST['tenSanPham']);
                $gia = trim($_POST['gia']);
                $moTa = trim($_POST['moTa']);
                $iddm = trim($_POST['iddm']);

                if (empty($tenSanPham)) {
                    $errors['tenSanPham'] = "Tên sản phẩm không được để trống.";
                }

                if (!is_numeric($gia) || (float)$gia <= 0) {
                    $errors['gia'] = "Giá sản phẩm phải là một số lớn hơn 0.";
                }

                if ($_FILES['hinhAnh']['error'] == 4) {
                    $errors['hinhAnh'] = "Vui lòng chọn hình ảnh cho sản phẩm.";
                } else {
                    $filename = $_FILES['hinhAnh']['name'];
                    $file_tmp = $_FILES['hinhAnh']['tmp_name'];
                    $file_size = $_FILES['hinhAnh']['size'];
                    $file_type = $_FILES['hinhAnh']['type'];
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];

                    if (!in_array($file_type, $allowed_types)) {
                        $errors['hinhAnh'] = "Chỉ chấp nhận file ảnh (jpeg, png, gif, bmp).";
                    } else if ($file_size > 2000000) {
                        $errors['hinhAnh'] = "Dung lượng file không được vượt quá 2MB.";
                    }
                }

                if (empty($errors)) {
                    $target_dir = "upload/";
                    $target_file = $target_dir . basename($filename);
                    if (move_uploaded_file($file_tmp, $target_file)) {
                        insert_sanpham($tenSanPham, $moTa, $gia, $iddm, $filename);
                        $thongbao = "Thêm thành công";
                    } else {
                        $errors['hinhAnh'] = "Có lỗi khi tải lên hình ảnh.";
                    }
                }
            }

            $listdm = loadAll_danhmuc();
            include "sanpham/add.php";
            break;

        case 'suasp':
            unset($_SESSION['error']);
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $sanPham = loadOne_sanpham($_GET['id']);
            }
            $listdm = loadAll_danhmuc();
            include "sanpham/update.php";
            break;

        case 'updatesp':
            $error = [];
            $thongbao = '';

            if (isset($_POST['capnhat']) && $_POST['capnhat']) {
                // Nhận dữ liệu từ form
                $id = $_POST['id'];
                $tenSanPham = trim($_POST['tenSanPham']);
                $gia = trim($_POST['gia']);
                $iddm = trim($_POST['iddm']);
                $moTa = trim($_POST['moTa']);
                $hinhAnhCu = $_POST['hinhAnhCu']; // Tên file hình ảnh cũ

                // Kiểm tra dữ liệu nhập vào
                if (empty($tenSanPham)) $error['tenSanPham'] = "Tên sản phẩm không được để trống.";
                if (!is_numeric($gia) || (float)$gia <= 0) $error['gia'] = "Giá sản phẩm phải là một số lớn hơn 0.";

                $filename = $hinhAnhCu; // Mặc định sử dụng hình ảnh cũ nếu không có hình mới
                if (!empty($_FILES['hinhAnh']['name'])) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = $_FILES['hinhAnh']['type'];
                    $fileSize = $_FILES['hinhAnh']['size'];

                    if (!in_array($fileType, $allowedTypes)) {
                        $error['hinhAnh'] = "Chỉ chấp nhận file ảnh (jpeg, png, gif).";
                    } elseif ($fileSize > 2097152) { // 2MB
                        $error['hinhAnh'] = "Kích thước file không được vượt quá 2MB.";
                    } else {
                        $file_tmp = $_FILES['hinhAnh']['tmp_name'];
                        $target_dir = "upload/";
                        $safe_filename = preg_replace(
                            array("/\s+/", "/[^-\.\w]+/"),
                            array("_", ""),
                            trim(basename($_FILES['hinhAnh']['name']))
                        );
                        $target_file = $target_dir . $safe_filename;

                        if (move_uploaded_file($file_tmp, $target_file)) {
                            $filename = $safe_filename;
                        } else {
                            $error['hinhAnh'] = "Có lỗi khi tải lên hình ảnh.";
                        }
                    }
                }
                if (empty($error)) {
                    update_sanpham($id, $tenSanPham, $moTa, $gia, $filename, $iddm);
                    $thongbao = "Cập nhật thành công.";
                }
            }

            // Tải lại dữ liệu sản phẩm và danh mục để hiển thị form
            $sanPham = loadOne_sanpham($id);
            $listdm = loadAll_danhmuc();

            include "sanpham/update.php";
            break;

        case 'xoasp':
            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                adjust_order_status_before_sanpham_delete($_GET['id']);
            }
            header("Location: http://gk_luna.test/admin/index.php?act=listsp");
            break;


            // Biến thể sản phẩm

        case 'listbienthe':
            $MaSanPham = $_GET['MaSanPham'];
            $listbienthe = loadAll_bienthe_sanpham();
            include 'bienthesanpham/list.php';
            break;
        case 'listOne':
            $MaSanPham = $_GET['MaSanPham'];
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;
            $totalVariant = get_total_variants($MaSanPham);
            $totalPages = ceil($totalVariant / $limit);
            $listOne = loadOne_bienthe_sanpham($MaSanPham, $limit, $offset);
            include 'bienthesanpham/listOne.php';
            break;
        case 'addvariant':
            $errors = [];
            $MaSanPham = $_GET['MaSanPham'] ?? null;
            if (isset($_POST['themmoi']) && $MaSanPham) {
                $color = $_POST['color'];
                $size = $_POST['size'];
                $quantity = $_POST['quantity'];

                if (empty($color)) {
                    $errors['color'] = 'Vui lòng nhập màu sắc!';
                }
                if (empty($size)) {
                    $errors['size'] = 'Vui lòng nhập kích thước!';
                }
                if (empty($quantity)) {
                    $errors['quantity'] = 'Vui lòng nhập số lượng!';
                }
                if ($size <= 0) {
                    $errors['size'] = 'Size phải lớn hơn 0!';
                }
                if ($quantity <= 0) {
                    $errors['quantity'] = 'Số lượng phải lớn hơn 0!';
                }
                if (empty($errors)) {
                    themHoacCapNhatBienThe($MaSanPham, $color, $size, $quantity);
                    $thongbao = "Thêm mới hoặc cập nhật biến thể sản phẩm thành công!";
                }
            }
            $listOne = loadOne_bienthe_sanpham($MaSanPham);
            include "bienthesanpham/add.php";
            break;
        case 'updatevariant':
            $errors = [];
            if (isset($_POST['capnhat']) && isset($_GET['MaBienThe'])) {
                $MaBienThe = $_GET['MaBienThe'];
                $color = trim($_POST['color']);
                $size = trim($_POST['size']);
                $quantity = trim($_POST['quantity']);
                // Khi kiểm tra và có lỗi, chúng ta sẽ lưu lỗi theo từng trường cụ thể
                if (empty($color)) {
                    $errors['color'] = 'Vui lòng nhập màu sắc!';
                }
                if (empty($size)) {
                    $errors['size'] = 'Vui lòng nhập kích thước!';
                } else if ($size <= 0) {
                    $errors['size'] = 'Kích thước phải lớn hơn 0!';
                }
                if (empty($quantity)) {
                    $errors['quantity'] = 'Vui lòng nhập số lượng!';
                } else if ($quantity <= 0) {
                    $errors['quantity'] = 'Số lượng phải lớn hơn 0!';
                }
                if (empty($errors)) {
                    update_bienthe($MaBienThe, $color, $size, $quantity);
                    $thongbao = "Cập nhật biến thể sản phẩm thành công!";
                }
            }

            if (isset($_GET['MaBienThe'])) {
                $bienthe = loadOne_bienthe($_GET['MaBienThe']);
                extract($bienthe);
            }
            include "bienthesanpham/update.php";
            break;
        case 'suavariant':
            unset($_SESSION['error']);
            if (isset($_GET['MaBienThe']) && $_GET['MaBienThe'] > 0) {
                $bienthe = loadOne_bienthe($_GET['MaBienThe']);
            }
            include "bienthesanpham/update.php";
            break;
        case 'xoavariant':
            if (isset($_GET['MaBienThe'])) {
                $bienthe = loadOne_bienthe($_GET['MaBienThe']);
                $MaSanPham = $bienthe['MaSanPham'];
                softdelete_bienthe($_GET['MaBienThe']);
                header("Location: http://gk_luna.test/admin/index.php?act=listOne&MaSanPham=?act=listvariant&MaSanPham=" . $MaSanPham);
                exit;
            }
            break;
            //Tài khoản(Users)
        case 'listUsers':

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;
            $totaluser = getTotalUser();
            $totalPages = ceil($totaluser / $limit);
            $list_users = loadAll_users($limit = 9, $offset = 0);

            include "users/list.php";
            break;
        case 'addUser':
            $errors = [];
            if (isset($_POST['themmoi']) && $_POST['themmoi']) {
                $userName = trim($_POST['userName']);
                $email = trim($_POST['email']);
                $pass = trim($_POST['pass']);
                $re_pass = trim($_POST['re_pass']);
                $fullname = trim($_POST['fullname']);
                $tel = trim($_POST['tel']);
                $address = trim($_POST['address']);

                if (empty($userName)) {
                    $errors['userName'] = "Tên người dùng không được để trống.";
                } elseif (checkUserName($userName)) {
                    $errors['userName'] = "Tên người dùng đã tồn tại, vui lòng chọn tên khác.";
                }

                if (empty($email)) {
                    $errors['email'] = "Email không được để trống.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = "Email không hợp lệ.";
                } elseif (checkEmail($email)) {
                    $errors['email'] = "Email đã tồn tại.";
                }

                if (empty($pass)) {
                    $errors['pass'] = "Mật khẩu không được để trống.";
                } elseif (strlen($pass) < 6 || !preg_match('/[^a-zA-Z\d]/', $pass)) {
                    $errors['pass'] = "Mật khẩu phải dài hơn 5 ký tự và có ít nhất một ký tự đặc biệt.";
                }

                if ($re_pass !== $pass) {
                    $errors['re_pass'] = "Mật khẩu nhập lại không trùng khớp.";
                }

                if (empty($fullname)) {
                    $errors['fullname'] = "Tên đầy đủ không được để trống.";
                }

                if (empty($tel)) {
                    $errors['tel'] = "Số điện thoại không được để trống.";
                }

                if (empty($address)) {
                    $errors['address'] = "Địa chỉ không được để trống.";
                }

                if (empty($errors)) {
                    insert_user($userName, $email, $pass, $fullname, $address, $tel);
                    $thongbao = "Thêm thành công";
                }
            }
            include "users/add.php";
            break;


        case 'suaUser':
            unset($_SESSION['error']);
            if (isset($_GET['id_user']) && $_GET['id_user'] > 0) {
                $sanPham = loadOne_user($_GET['id_user']);
            }

            include "users/update.php";
            break;

        case 'updateUser':
            $errors = [];
            if (isset($_POST['capnhat']) && $_POST['capnhat']) {
                $id_user = ($_POST['id_user']);
                $userName = trim($_POST['userName']);
                $email = trim($_POST['email']);
                $pass = trim($_POST['pass']);
                $fullname = trim($_POST['fullname']);
                $tel = trim($_POST['tel']);
                $address = trim($_POST['address']);
                $role = ($_POST['role']);
                $hinhAnhCu = $_POST['hinhAnhCu'];

                // Sửa thông điệp lỗi
                if (empty($userName)) {
                    $errors['userName'] = "Tên người dùng không được để trống.";
                }
                if (empty($email)) {
                    $errors['email'] = "Email không được để trống.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = "Email không hợp lệ.";
                }
                if (empty($pass)) {
                    $errors['pass'] = "Mật khẩu không được để trống.";
                } elseif (strlen($pass) < 6 || !preg_match('/[^a-zA-Z\d]/', $pass)) {
                    $errors['pass'] = "Mật khẩu phải dài hơn 5 ký tự và có ít nhất một ký tự đặc biệt.";
                }
                if (empty($fullname)) {
                    $errors['fullname'] = "Tên đầy đủ không được để trống.";
                }
                if (empty($tel)) {
                    $errors['tel'] = "Số điện thoại không được để trống.";
                }
                if (empty($address)) {
                    $errors['address'] = "Địa chỉ không được để trống.";
                }
                $filename = $hinhAnhCu; // Mặc định sử dụng hình ảnh cũ nếu không có hình mới
                if (!empty($_FILES['hinhAnh']['name'])) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = $_FILES['hinhAnh']['type'];
                    $fileSize = $_FILES['hinhAnh']['size'];

                    if (!in_array($fileType, $allowedTypes)) {
                        $error['hinhAnh'] = "Chỉ chấp nhận file ảnh (jpeg, png, gif).";
                    } elseif ($fileSize > 2097152) { // 2MB
                        $error['hinhAnh'] = "Kích thước file không được vượt quá 2MB.";
                    } else {
                        $file_tmp = $_FILES['hinhAnh']['tmp_name'];
                        $target_dir = "upload/";
                        $safe_filename = preg_replace(
                            array("/\s+/", "/[^-\.\w]+/"),
                            array("_", ""),
                            trim(basename($_FILES['hinhAnh']['name']))
                        );
                        $target_file = $target_dir . $safe_filename;

                        if (move_uploaded_file($file_tmp, $target_file)) {
                            $filename = $safe_filename;
                        } else {
                            $error['hinhAnh'] = "Có lỗi khi tải lên hình ảnh.";
                        }
                    }
                }
                if (empty($error)) {
                    update_user($id_user, $userName, $filename, $email, $pass, $fullname, $address, $tel, $role);
                    $thongbao = "Cập nhật thành công";
                }
            }

            include "users/update.php";
            break;

        case 'xoaUser':
            if (isset($_GET['id_user']) && ($_GET['id_user'] > 0)) {
                delete_User($_GET['id_user']);
            }
            header("Location: http://gk_luna.test/admin/index.php?act=listUsers");
            break;
        case 'update_status':
            // Lấy dữ liệu từ form
            $newStatus = $_POST['new_status'];
            $MaDonHang = $_POST['MaDonHang'];
            $currentStatus = getCurrentStatus($MaDonHang);
            updateOrderStatus($MaDonHang, $newStatus);
            header('Location: index.php?act=orders&status_updated=true');
            exit();

            break;

        case 'orders':
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9; // Số lượng đơn hàng hiển thị trên mỗi trang
            $offset = ($page - 1) * $limit;
            $dateRange = ''; // Khởi tạo $dateRange

            if (isset($_POST['update_status']) && !empty($_POST['update_status'])) {
                // Lấy dữ liệu từ form
                $newStatus = $_POST['new_status'];
                $MaDonHang = $_POST['MaDonHang'];
                $currentStatus = getCurrentStatus($MaDonHang);
                updateOrderStatus($MaDonHang, $newStatus);
                header('Location: index.php?act=orders');
            }

            if (isset($_POST['filter'])) {
                $orderStatus = isset($_POST['status']) ? $_POST['status'] : '';
                $priceRange = isset($_POST['price_range']) ? $_POST['price_range'] : '';
                $searchKeyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';

                // Xử lý giá trị time_period từ form
                if (isset($_POST['time_period']) && !empty($_POST['time_period'])) {
                    switch ($_POST['time_period']) {
                        case 'today':
                            $startDate = date('Y-m-d');
                            $endDate = date('Y-m-d');
                            break;
                        case 'this_week':
                            $startDate = date('Y-m-d', strtotime('monday this week'));
                            $endDate = date('Y-m-d', strtotime('sunday this week'));
                            break;
                        case 'this_month':
                            $startDate = date('Y-m-01'); // Ngày đầu tiên của tháng
                            $endDate = date('Y-m-t'); // Ngày cuối cùng của tháng
                            break;
                        case 'this_year':
                            $startDate = date('Y-01-01'); // Ngày đầu tiên của năm
                            $endDate = date('Y-12-31'); // Ngày cuối cùng của năm
                            break;
                        case 'custom':
                            $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
                            $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
                            break;
                        default:
                            $startDate = '';
                            $endDate = '';
                            break;
                    }
                    if (!empty($startDate) && !empty($endDate)) {
                        $dateRange = $startDate . 'to' . $endDate;
                    }
                }

                $totalOrder = getTotalFilteredOrders($orderStatus, $priceRange, $dateRange, $searchKeyword);
                $list_orders = filterOrder($orderStatus, $priceRange, $dateRange, $searchKeyword, $limit, $offset);
            } else {
                $totalOrder = getTotalOrders();
                $list_orders = loadAll_orders($limit, $offset);
            }

            $totalPages = ceil($totalOrder / $limit);
            include "order/list.php";
            break;

        case 'detail':
            $MaDonHang = $_GET['MaDonHang'];
            $details = detailOrder($MaDonHang);
            include "order/detail.php";
            break;

        case 'bieudo':
            if (isset($_POST['timeframe'])) {
                $timeframe = $_POST['timeframe'];
                switch ($timeframe) {
                    case 'this_week':
                        $startDate = new DateTime('monday this week');
                        $endDate = new DateTime('sunday this week');
                        break;
                    case 'this_month':
                        $startDate = new DateTime('first day of this month');
                        $endDate = new DateTime('last day of this month');
                        break;
                    case 'this_quarter':
                        $currentMonth = date('m');
                        $currentYear = date('Y');
                        if ($currentMonth <= 3) {
                            $startDate = new DateTime("$currentYear-01-01");
                            $endDate = new DateTime("$currentYear-03-31");
                        } elseif ($currentMonth <= 6) {
                            $startDate = new DateTime("$currentYear-04-01");
                            $endDate = new DateTime("$currentYear-06-30");
                        } elseif ($currentMonth <= 9) {
                            $startDate = new DateTime("$currentYear-07-01");
                            $endDate = new DateTime("$currentYear-09-30");
                        } else {
                            $startDate = new DateTime("$currentYear-10-01");
                            $endDate = new DateTime("$currentYear-12-31");
                        }
                        break;
                    case 'this_year':
                        $startDate = new DateTime('first day of January this year');
                        $endDate = new DateTime('last day of December this year');
                        break;
                    case 'custom':
                        $startDate = isset($_POST['start_date']) ? new DateTime($_POST['start_date']) : new DateTime('today');
                        $endDate = isset($_POST['end_date']) ? new DateTime($_POST['end_date']) : new DateTime('today');
                        break;
                    default:
                        // Nếu không có lựa chọn nào, mặc định là tháng này
                        $startDate = new DateTime('first day of this month');
                        $endDate = new DateTime('last day of this month');
                }
                $startDate = $startDate->format('Y-m-d');
                $endDate = $endDate->format('Y-m-d');
            } else {
                // Mặc định lấy dữ liệu của tháng trước
                $startDate = new DateTime('first day of this month');
                $startDate = $startDate->format('Y-m-d');
                $endDate = new DateTime();
                $endDate = $endDate->format('Y-m-d');
            }
            $totalRevenue = totalRevenue();
            $revenueData = revenue();
            $totalOrder = getTotalOrders();
            $total = calculateTotalRevenue($startDate, $endDate);
            $revenueData = revenueWithAllDays($startDate, $endDate);
            $totalusers = totalUsers();
            include "bieudo/bieudo.php";
            break;
            //COMMENT

        case 'comment':
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9; // Số lượng bình luận hiển thị trên mỗi trang
            $offset = ($page - 1) * $limit;
            if (isset($_POST['filter'])) {
                // Đảm bảo sử dụng đúng tên trường 'keyword' từ form
                $searchKeyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                // Gọi hàm filter_commnet với thứ tự tham số chính xác
                $comments = filter_commnet($limit, $offset, $searchKeyword);
                $totalComment = getTotalCommentFiltered($searchKeyword);
            } else {
                $totalComment = getTotalComment();
                $comments = allComment($limit, $offset);
            }

            $totalPages = ceil($totalComment / $limit);
            include "danhgia/list.php";
            break;


            case 'xoacm':
                if (isset($_GET['MaDanhGia']) && ($_GET['MaDanhGia'] > 0)) {
                    $MaDanhGia = $_GET['MaDanhGia'];
                    
                    delete_comment($_GET['MaDanhGia']);
                }
                header("Location: http://gk_luna.test/admin/index.php?act=comment");
                break;
        default:
            include "home.php";
            break;
    }
}
include "footer.php";
ob_end_flush();
