<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Ansonika">
	<title>GK-LUNA</title>
	<!-- Bootstrap CSS -->
	<!-- Bootstrap CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


	<!-- Favicons-->
	<link rel="shortcut icon" href="view/img/gk1.png" >
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="view/img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="viewimg/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="view/img/apple-touch-icon-144x144-precomposed.png">

	<!-- GOOGLE WEB FONT -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

	<!-- BASE CSS -->
	<link rel="stylesheet" href="view/css/bootstrap.min.css">
	<link rel="stylesheet" href="view/css/style.css">
	<link rel="stylesheet" href="view/css/home_1.css">
	<link rel="stylesheet" href="view/css/product_page.css">
	<link rel="stylesheet" href="view/css/custom.css">
	<link rel="stylesheet" href="view/css/cart.css">
	<link rel="stylesheet" href="view/css/account.css">
	<link rel="stylesheet" href="view/css/listing.css">
	<link rel="stylesheet" href="view/css/error_track.css">
	<link rel="stylesheet" href="view/css/blog.css">
	<link rel="stylesheet" href="view/css/checkout.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>

	<div id="page">

		<header class="version_1">
			<div class="layer"></div><!-- Mobile menu overlay mask -->
			<div class="main_header">
				<div class="container">
					<div class="row small-gutters">
						<div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
							<div id="logo">
								<a href="index.php"><img src="view/img/gk1.png" alt="" width="150" height="50"></a>
							</div>
						</div>
						<nav class="col-xl-6 col-lg-7">
							<a class="open_close" href="javascript:void(0);">
								<div class="hamburger hamburger--spin">
									<div class="hamburger-box">
										<div class="hamburger-inner"></div>
									</div>
								</div>
							</a>
							<!-- Mobile menu button -->
							<div class="main-menu">
								<div id="header_menu">
									<a href="index.php"><img src="view/img/logo_black.svg" alt="" width="100" height="35"></a>
									<a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
								</div>
								<ul>

									<li>
										<a href="index.php">Trang chủ</a>
									</li>
									<li>
										<a href="index.php?act=sanpham">Sản phẩm</a>
									</li>
									<li>
										<a href="index.php?act=blog">Tin tức</a>
									</li>
									<li>
										<a href="index.php">Về chúng tôi</a>
									</li>
								</ul>
							</div>
							<!--/main-menu -->
						</nav>
						<div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
							<a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94
									423-23-221</strong></a>
						</div>
					</div>
					<!-- /row -->
				</div>
			</div>
			<!-- /main_header -->

			<div class="main_nav Sticky">
				<div class="container">
					<div class="row small-gutters">
						<div class="col-xl-3 col-lg-3 col-md-3">

						</div>
						<div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
							<div class="custom-search-input">
								<form action="index.php" method="get">
									<input type="hidden" name="act" value="search">
									<input type="text" name="keyword" placeholder="Search over 10.000 products" required>
									<button type="submit"><i class="header-icon_search_custom"></i></button>
								</form>
								<?php
								if (isset($_SESSION['no_results'])) {
									echo '<div class="alert alert-warning" role="alert">' . $_SESSION['no_results'] . '</div>';
									unset($_SESSION['no_results']);
								}
								?>
							</div>

						</div>

						<div class="col-xl-3 col-lg-2 col-md-3">
							<ul class="top_tools">
								<li>
								<a href="index.php?act=showcart" >Giỏ Hàng</a>
								</li>
								<li>
									<a href="index.php?act=checkout" class="wishlist"><span>Wishlist</span></a>
								</li>
								<li>
									<div class="dropdown dropdown-access">
										<?php if (isset($_SESSION['user'])) :
										?>
											<a href="index.php?act=profile" class="access_link"><span><?php echo htmlspecialchars($_SESSION['user']['userName']); ?></span></a>
											<div class="dropdown-menu">
												<ul>
													<li><a href="index.php?act=profile"><i class="ti-user"></i>My Profile</a></li>

													<li><a href="index.php?act=logout" class="btn_1">Logout</a></li> <!-- Tùy chọn đăng xuất -->
												</ul>
											</div>
										<?php else : ?>
											<a href="index.php?act=account" class="access_link"><span>Account</span></a>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
												<a class="dropdown-item text-danger" href="index.php?act=register">Đăng ký</a>
												<a class="dropdown-item text-primary" href="index.php?act=account">Đăng nhập</a>
											</div>
										<?php endif; ?>
									</div>
									<!-- /dropdown-access-->
								</li>
								<li>
									<a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
								</li>
								<li>
									<a href="#menu" class="btn_cat_mob">
										<div class="hamburger hamburger--spin" id="hamburger">
											<div class="hamburger-box">
												<div class="hamburger-inner"></div>
											</div>
										</div>
										Categories
									</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- /row -->
				</div>
				<div class="search_mob_wp">
					<input type="text" class="form-control" placeholder="Search over 10.000 products">
					<input type="submit" class="btn_1 full-width" value="Search">
				</div>
				<!-- /search_mobile -->
			</div>
			<!-- /main_nav -->
		</header>