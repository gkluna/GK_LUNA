<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .header-top .logo {
            display: flex;
            align-items: center;
        }

        .header-top img {
            height: 50px;
        }

        nav.navbar {
            margin-top: 20px;
        }

        .user-icon img {
            height: 40px;
            border-radius: 50%;

        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            position: absolute;
            background-color: #fff;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .navbar {
            background-color: #007bff;
            /* Màu xanh Bootstrap's primary color */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #fff;
        }

        .nav-link:hover {
            color: #d4d4d4;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header-top">
            <div class="logo">
                <a href="index.php">
                    <img src="upload/gk1.png" alt="Logo">
                </a>
            </div>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white bg-primary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> ADMIN
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Đăng xuất</a>
                </div>
            </div>



        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=bieudo">Trang chủ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=listdm">Danh Mục</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=listsp">Sản Phẩm</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=listUsers">Tài khoản người dùng</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=orders">Đơn hàng</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?act=comment">Đánh giá</a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>