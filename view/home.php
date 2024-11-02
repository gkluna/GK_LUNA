<main>
	<div id="carousel-home">
		<div class="owl-carousel owl-theme">
			<div class="owl-slide cover" style="background-image: url(admin/upload/banner-slide-1.png);">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-end">
							<div class="col-lg-6 static">
								<div class="slide-text text-end white">
									<!-- <div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="index.php?act=sanpham" role="button">Shop Now</a></div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/owl-slide-->
			<div class="owl-slide cover" style="background-image: url(admin/upload/banner-quang-cao-giay-6.webp);">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-6 static">
								<div class="slide-text white">
									<!-- <div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="index.php?act=sanpham" role="button">Shop Now</a></div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="icon_drag_mobile"></div>
	</div>
	<!--/carousel-->




	<div class="container margin_60_35">
		<div class="main_title">
			<h2>BÁN CHẠY NHẤT</h2>
		</div>
		<div class="row small-gutters">
			<?php foreach ($sellingProducts as $product) : ?>
				<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure>


							<?php
							$linksp = "index.php?act=spct&id=" . $product['id'];
							$imagePath = "admin/upload/" . $product['hinhAnh'];

							if (file_exists($imagePath) && is_file($imagePath)) {
								echo "<a href='$linksp'>
									<img class='img-fluid lazy' src='$imagePath'  alt=''>
									</a>";
							}
							?>



							
						</figure>
						<?php
						$linksp = "index.php?act=spct&id=" . $product['id'];
						echo "<a href='$linksp'>
								<h3> '" . $product['tenSanPham'] . "'</h3>
								</a>";
						?>

						<div class="price_box">
							<span class="price"><?php echo $product['gia'] ?> VND</span>

						</div>

					</div>
					<!-- /grid_item -->
				</div>
			<?php endforeach; ?>



		</div>
		<!-- /row -->
	</div>
	<!-- /container -->

	<div class="featured lazy" data-bg="url(admin/upload/banner2.png)">
		<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
			<div class="container margin_60">
				<div class="row justify-content-center justify-content-md-start">
					<div class="col-lg-6 wow" data-wow-offset="150">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /featured -->

	<div class="container margin_60_35">
		<div class="main_title">
			<h2>SẢN PHẨM Mới</h2>
		</div>
		<div class="owl-carousel owl-theme products_carousel">
			<?php foreach ($newProduct as $new) : ?>
				<div class="item">
					<div class="grid_item">
						<span class="ribbon new">New</span>
						<figure>
							<?php
							$linksp = "index.php?act=spct&id=" . $new['id'];
							$imagePath = "admin/upload/" . $new['hinhAnh'];

							if (file_exists($imagePath) && is_file($imagePath)) {
								echo "<a href='$linksp'>
									<img class='owl-lazy' src='$imagePath'  alt=''>
									</a>";
							}
							?>
						</figure>
						<?php
						$linksp = "index.php?act=spct&id=" . $new['id'];
						echo "<a href='$linksp'>
								<h3> '" . $new['tenSanPham'] . "'</h3>
								</a>";
						?>
						<div class="price_box">
							<span class="new_price"><?php echo $new['gia'] ?></span>
						</div>
					</div>
					<!-- /grid_item -->
				</div>
			<?php endforeach; ?>
		</div>
		<!-- /products_carousel -->
	</div>
	<!-- /container -->
	
	<!-- /container -->
</main>
<!-- /main -->