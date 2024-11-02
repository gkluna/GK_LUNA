<?php
session_start();
ob_start();
include "model/pdo.php";
include "model/sanpham.php";
include "model/danhmuc.php";
include "model/bienthesanpham.php";
include "model/users.php";
include "model/cart.php";
include "model/donhang.php";
include "model/comment.php";
include "view/header.php";
include "global.php";
$sellingProducts = sellingHome();
$newProduct = newProduct();

if ((isset($_GET['act'])) && ($_GET['act'] != "")) {
    $act = $_GET['act'];
    switch ($act) {

        case 'sanpham':
            $categories = loadAll_danhmuc(); // Luôn load danh sách danh mục để hiển thị bộ lọc

            // Xử lý phân trang
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;

            if (isset($_POST['timkiem'])) {
                // Khi có request tìm kiếm, áp dụng bộ lọc
                $categoriesFilter = isset($_POST['category']) ? $_POST['category'] : [];
                $priceRange = isset($_POST['price_range']) ? $_POST['price_range'] : '';
                $priceSort = isset($_POST['price_sort']) ? $_POST['price_sort'] : 'NgayTao DESC';

                // Lấy tổng số sản phẩm và sản phẩm theo điều kiện bộ lọc
                $totalSanPham = getTotalSanPhamFiltered($categoriesFilter, $priceRange); // Hàm này phải được điều chỉnh để áp dụng bộ lọc
                $products = getProductsFiltered($categoriesFilter, $priceRange, $priceSort, $limit, $offset);
            } else {
                // Nếu không có request tìm kiếm, hiển thị sản phẩm mặc định
                $totalSanPham = getTotalSanPham(); // Lấy tổng số sản phẩm không áp dụng bộ lọc
                $products = loadAll_sanpham($limit, $offset);
            }

            $totalPages = ceil($totalSanPham / $limit); // Tính tổng số trang dựa trên tổng số sản phẩm
            include 'view/sanpham.php'; // Hiển thị trang sản phẩm với bộ lọc và sản phẩm
            break;

        case 'spct':
            $MaSanPham = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $comments = loadAll_comment($MaSanPham);
            if ($MaSanPham > 0) {
                $sanPham = loadOne_sanpham($MaSanPham);
                $Products = loadOne_sanpham_cungloai($sanPham['id'], $sanPham['iddm']);
                $variants = loadOne_bienthe_sanpham($MaSanPham);
                $colors = array_unique(array_column($variants, 'color'));
                $sizes = array_unique(array_column($variants, 'size'));
                sort($sizes);
                include "view/spchitiet.php";
            } else {
                echo "<script>alert('Sản phẩm không tồn tại!'); window.location = 'index.php';</script>";
            }
            break;


        case 'dangnhap':
            $emailError = $passwordError = $generalError = "";
            if (isset($_POST['dangnhap']) && ($_POST['dangnhap'])) {
                if (empty($_POST['email'])) {
                    $emailError = "Email là bắt buộc.";
                }

                if (empty($_POST['pass'])) {
                    $passwordError = "Mật khẩu là bắt buộc.";
                }

                if (empty($emailError) && empty($passwordError)) {
                    // Tiến hành kiểm tra đăng nhập nếu không có lỗi từ input
                    $email = $_POST['email'];
                    $pass = $_POST['pass'];
                    $checkuser = checkUser($email, $pass);

                    if (is_array($checkuser) && count($checkuser) > 0) {
                        $_SESSION['user'] = $checkuser;
                        $_SESSION['user_id'] = $checkuser['id_user'];
                        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
                        header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . '/index.php');

                        exit;
                    } else {
                        $generalError = "Sai tài khoản hoặc mật khẩu.";
                    }
                }
            }
            include "view/acc.php";
            break;
        case "account":
            include "view/acc.php";
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header("Location: http://gk_luna.test/");
            exit;
            break;
        case 'quenmatkhau':
            if (isset($_POST['guiemail'])) {
                $email = $_POST['email_forgot'];
                $sendMailMess = sendMail($email);
            }
            include "view/acc.php";
            break;
        case 'profile':
            if (!isset($_SESSION['user'])) {
                header('Location: index.php?act=account');
                exit;
            }
            $id_user = $_SESSION['user']['id_user'];
            $profile = profile($id_user);

            include "view/profile.php";
            break;
        case 'register':
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
                    $errors['userName'] = "Tên người dùng đã tồn tại.";
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
                } elseif (!PassValid($pass)) {
                    $errors['pass'] = "Mật khẩu phải từ 6-12 ký tự, bao gồm ít nhất 1 số và 1 ký tự đặc biệt.";
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

                // Nếu không có lỗi, tiến hành thêm người dùng
                if (empty($errors)) {
                    insert_user($userName, $email, $pass, $fullname, $address, $tel);
                    $thongbao = "Thêm thành công";
                }
            }
            include "view/register.php";
            break;
        case 'search':
            if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
                $keyword = trim($_GET['keyword']);
                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                $limit = 6;
                $offset = ($page - 1) * $limit;


                $totalResults = totalSearch($keyword);
                $totalPages = ceil($totalResults / $limit);



                $searchResults = getSearchResult($keyword, $limit, $offset);

                if (empty($searchResults)) {
                    $_SESSION['no_results'] = "Không tìm thấy sản phẩm nào phù hợp với từ khóa '$keyword'.";
                } else {
                    if (isset($_SESSION['no_results'])) {
                        unset($_SESSION['no_results']);
                    }
                }

                // Chuyển kết quả tìm kiếm, số trang và thông tin phân trang vào file view/search.php để hiển thị
                include "view/search.php";
            } else {
                $_SESSION['no_results'] = "Vui lòng nhập từ khóa để tìm kiếm.";
            }
            break;
        case 'showcart':
            $cartItems = [];
            if (isset($_SESSION['user'])) {
                // Người dùng đã đăng nhập, lấy giỏ hàng từ CSDL
                $user_id = $_SESSION['user']['id_user'];
                $cartItems = getCartItemsFromDB($user_id);
            } else {

                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $productDetails = getProductDetailsById($item['product_id'], $item['color'], $item['size']);
                        if ($productDetails) {
                            $productDetails['userSelectedQuantity'] = $item['userSelectedQuantity'];
                            $productDetails['MaBienThe'] = $productDetails['id'];
                            unset($productDetails['id']);
                            $cartItems[] = $productDetails;
                        }
                    }
                }
            }

            $_SESSION['cartItems'] = $cartItems;

            include "view/cart.php";
            exit;
            break;
        case 'checkout':
            include "view/checkout.php";
            break;

        case 'confirm':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Lấy dữ liệu từ POST request
                $productsData = isset($_POST['productsData']) ? $_POST['productsData'] : '';
                $totalCost = isset($_POST['totalCost']) ? $_POST['totalCost'] : 0;

                // Giả sử người dùng đã đăng nhập và ID người dùng có trong session
                $userId = $_SESSION['user']['id_user'];

                if ($userId == 0) {
                    // Nếu không tìm thấy ID người dùng, có thể chuyển hướng về trang đăng nhập hoặc trang lỗi
                    header('Location: index.php?act=dangnhap');
                    exit;
                }

                // Chuyển JSON thành array
                $products = json_decode($productsData, true);

                if (!empty($products)) {
                    // Tạo đơn hàng
                    $orderId = donhang($userId, $totalCost);

                    foreach ($products as $product) {
                        $variantId = $product['productId'];
                        $productQuantity = $product['quantity'];
                        $productPrice = $product['price'];
                        $productColor = $product['color'];
                        $productSize = $product['size'];

                        $productId = getIdForProduct($variantId, $productColor, $productSize);
                        insertDetail($orderId, $productId, $variantId, $productQuantity, $productPrice);
                        updateQuantity($variantId, $productQuantity);
                        deleteProductFromCart($variantId, $userId);
                        unset($_SESSION['cart']);
                    }

                    include "view/confirm.php";
                    exit;
                } else {
                    // Xử lý trường hợp không có sản phẩm nào trong đơn hàng
                    echo "Không có sản phẩm nào trong đơn hàng!";
                }
            } else {
                // Nếu không phải POST request, chuyển hướng người dùng về trang chủ hoặc trang khác
                header('Location: index.php');
                exit;
            }

            break;
        default:
            include "view/home.php";
            break;
    }
} else {
    include "view/home.php";
}

include "view/footer.php";
ob_end_flush();
