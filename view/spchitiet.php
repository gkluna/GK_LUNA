<div>
	<div class="container margin_30">
		<div class="countdown_inner">
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="all">
					<div class="slider">
						<div class="owl-carousel owl-theme main">
							<?php
							$hinh = $img_path . $sanPham['hinhAnh'];
							$link_sp = "index.php?act=spct&id=" . $sanPham['id'];
							echo '<div class="item"><img src="' . $hinh . '" alt="' . $sanPham['tenSanPham'] . '"></div>';
							?>

						</div>
						<div class="left nonl"><i class="ti-angle-left"></i></div>

					</div>

				</div>
			</div>
			<div class="col-md-6">
				<div class="breadcrumbs">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="index.php?act=sanpham">Sản Phẩm</a></li>
						<li><?php echo $sanPham['tenSanPham']; ?></li>
					</ul>
				</div>
				<!-- /page_header -->
				<div class="prod_info">
					<h1><?php echo $sanPham['tenSanPham']; ?></h1>
					<span class="rating">
						<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
						<em></em>
					</span>
					<p><small>SKU: <?php echo $sanPham['id']; ?></small></p>
					<p><strong>Trong kho còn:</strong> <span id="quantityDisplay"><?php echo $sanPham['tongSoLuong'] > 0 ? $sanPham['tongSoLuong'] : 'Hết hàng'; ?></span></p>
					<div class="prod_options">
						<div class="row">
							<div class="row">
								<label class="col-xl-5 col-lg-5 col-md-6 col-6 pt-0"><strong>Color</strong></label>
								<div class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
									<ul>
										<?php foreach ($colors as $color) : ?>
											<li><a href="#" class="color" style="background-color:<?php echo $color; ?>;" data-color="<?php echo $color; ?>"></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Size</strong> - Size Guide <a href="#0" data-bs-toggle="modal" data-bs-target="#size-modal"><i class="ti-help-alt"></i></a></label>
							<div class="col-xl-4 col-lg-5 col-md-6 col-6">
								<div class="custom-select-form">
									<select class="wide" id="sizeSelect">
										<?php foreach ($sizes as $size) : ?>
											<option value="<?php echo $size; ?>"><?php echo $size; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Quantity</strong></label>
							<div class="col-xl-4 col-lg-5 col-md-6 col-6">
								<div class="numbers-row">
									<input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-6">
							<div class="price_main"><span class="new_price">Giá :<?= number_format($sanPham['gia'], 0, ',', '.') ?> VNĐ</span> <span class="old_price"></span></div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="btn_add_to_cart">
								<button id="addToCartButton" class="btn_1 <?php echo $sanPham['tongSoLuong'] > 0 ? '' : 'disabled'; ?>">
									<?php echo $sanPham['tongSoLuong'] > 0 ? 'Thêm vào giỏ' : 'Hết hàng'; ?>
								</button>
							</div>
						</div>
					</div>
				</div>



				<!-- /product_actions -->
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->

	<div class="tabs_product">
		<div class="container">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">MÔ TẢ</a>
				</li>
				<li class="nav-item">
					<a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">BÌNH LUẬN</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /tabs_product -->
	<div class="tab_content_wrapper">
		<div class="container">
			<div class="tab-content" role="tablist">
				<div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
					<div class="card-header" role="tab" id="heading-A">
						<h5 class="mb-0">
							<a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="false" aria-controls="collapse-A">
								Mô tả
							</a>
						</h5>
					</div>
					<div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
						<div class="card-body">
							<div class="row justify-content-between">
								<div class="col-lg-6">

									<h3><?php echo $sanPham['moTa']; ?></h3>
								</div>
								<div class="col-lg-5">
									<h3>Thông số kỹ thuật</h3>
									<div class="table-responsive">
										<table class="table table-sm table-striped">
											<tbody>
												<tr>
													<td><strong>Color</strong></td>
													<td><?php foreach ($colors as $color) : ?>
															<?php echo $color; ?>
														<?php endforeach; ?>
													</td>
												</tr>
												<tr>
													<td><strong>Size</strong></td>
													<td><?php foreach ($sizes as $size) : ?>
															<?php echo $size; ?>
														<?php endforeach; ?></td>
												</tr>
												<tr>
													<td><strong>Trọng lượng</strong></td>
													<td>0.6kg</td>
												</tr>
												<tr>
													<td><strong>Nhà Sản xuất</strong></td>
													<td>GK LUNA</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /table-responsive -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /TAB A -->
				<div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
					<div class="card-header" role="tab" id="heading-B">
						<h5 class="mb-0">
							<a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
								Bình Luận
							</a>
						</h5>
					</div>
					<div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
						<div class="card-body">
							<div id="comments-display" class="mt-4">
								<?php foreach ($comments as $comment) : ?>
									<div>
										<?php
										$imagePath = "admin/upload/" . $comment['hinhAnh'];
										if (file_exists($imagePath) && is_file($imagePath)) : ?>
											<img src="<?= $imagePath ?>" class="rounded-circle mr-3" alt="Avatar" style="width: 40px; height: 40px;">
										<?php endif; ?>
										<h6 class="mb-1"><?= $comment['userName'] ?></h6>
										<div class="text-muted" style="font-size: 0.8rem;"><em><?= $comment['NgayTao'] ?></em></div>
										<p class="mt-2"><?= $comment['BinhLuan'] ?></p>
									</div>
								<?php endforeach; ?>
							</div>

							<?php if (isset($_SESSION['user'])) : ?>
								<div class="mb-3">
									<textarea id="comment-textarea" class="form-control" rows="3" placeholder="Viết bình luận..."></textarea>
								</div>
								<input type="hidden" id="maSanPham" value="<?php echo $sanPham['id']; ?>">
								<button id="submit-comment" class="btn btn-primary">Gửi</button>
							<?php else : ?>
								<p class="text-warning">Bạn cần <a href="index.php?act=dangnhap">đăng nhập</a> để bình luận.</p>
							<?php endif; ?>

							<div id="comment-notification" class="mt-3"></div>
						</div>
					</div>
				</div>


				<!-- /tab B -->
			</div>
			<!-- /tab-content -->
		</div>
		<!-- /container -->
	</div>
	<!-- /tab_content_wrapper -->

	<div class="container margin_60_35">
		<div class="main_title">
			<h2>Có Thể Bạn Quan Tâm</h2>
			<span>Products</span>

		</div>
		<div class="owl-carousel owl-theme products_carousel">
			<?php
			foreach ($Products as $product) {
				extract($product);
				$hinh = $img_path . $hinhAnh;
				$linksp = "index.php?act=spct&id=" . $product['id'];
			?>

				<div class="item">
					<div class="grid_item">

						<figure>
							<a href="<?php echo $linksp; ?>">
								<img class="owl-lazy" src="<?php echo $hinh; ?>" alt="img">
							</a>
						</figure>

						<a href="<?php echo $linksp; ?>">
							<h3><?php echo $tenSanPham; ?></h3>
						</a>
						<div class="price_box">
							<span class="new_price"><?php echo $gia; ?></span>
						</div>

					</div>
					<!-- /grid_item -->
				</div>
				<!-- /item -->
			<?php
			}
			?>
		</div>


		<!-- /products_carousel -->
	</div>



	<!-- /container -->

	<div class="feat">
		<div class="container">
			<ul>
				<li>
					<div class="box">
						<i class="ti-gift"></i>
						<div class="justify-content-center">
							<h3>Free Shipping</h3>
							<p>For all oders over $99</p>
						</div>
					</div>
				</li>
				<li>
					<div class="box">
						<i class="ti-wallet"></i>
						<div class="justify-content-center">
							<h3>Secure Payment</h3>
							<p>100% secure payment</p>
						</div>
					</div>
				</li>
				<li>
					<div class="box">
						<i class="ti-headphone-alt"></i>
						<div class="justify-content-center">
							<h3>24/7 Support</h3>
							<p>Online top support</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!--/feat-->

</div>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var maxQuantity = 0; // Biến này sẽ giữ giá trị số lượng tối đa có sẵn

		function updateQuantityAndAvailability(color, size) {
			$.ajax({
				url: '../getVariantQuantity.php',
				type: 'GET',
				data: {
					product_id: <?php echo json_encode($sanPham['id']); ?>,
					color: color,
					size: size
				},
				dataType: 'json',
				success: function(response) {
					var addToCartButton = $('#addToCartButton');
					if (response.available) {
						$('#quantityDisplay').text(response.quantity + " sản phẩm có sẵn");
						addToCartButton.prop('disabled', false).removeClass('disabled').text('Thêm vào giỏ');
						maxQuantity = response.quantity; // Cập nhật số lượng tối đa
						$('#quantity_1').attr('max', maxQuantity); // Cập nhật giới hạn của trường nhập số lượng
					} else {
						$('#quantityDisplay').text('Hết hàng');
						addToCartButton.prop('disabled', true).addClass('disabled').text('Hết hàng');
						maxQuantity = 0; // Cập nhật số lượng tối đa khi hết hàng
					}
				}
			});
		}

		// Cập nhật số lượng và khả năng có hàng khi người dùng thay đổi lựa chọn màu sắc hoặc kích thước
		$('.color').click(function(e) {
			e.preventDefault();
			var color = $(this).data('color');
			var size = $('#sizeSelect').val();
			updateQuantityAndAvailability(color, size);
		});

		$('#sizeSelect').change(function() {
			var size = $(this).val();
			var color = $('.color.active').data('color');
			updateQuantityAndAvailability(color, size);
		});

		// Kiểm tra và cảnh báo người dùng nếu họ chọn số lượng vượt quá số lượng có sẵn
		$('#quantity_1').on('input change', function() {
			var currentQuantity = parseInt($(this).val());
			if (currentQuantity > maxQuantity) {
				$(this).val(maxQuantity); // Đặt lại giá trị về số lượng tối đa có sẵn
				alert("Số lượng bạn chọn vượt quá số lượng sản phẩm có sẵn.");
			}
		});

		// Xử lý thêm vào giỏ hàng
		$('#addToCartButton').click(function() {
			var color = $('.color.active').data('color');
			var size = $('#sizeSelect').val();
			var userSelectedQuantity = parseInt($('#quantity_1').val());

			if (!color || !size || userSelectedQuantity <= 0 || userSelectedQuantity > maxQuantity) {
				alert('Vui lòng chọn đầy đủ màu sắc, kích thước và số lượng phải lớn hơn 0 và không vượt quá số lượng có sẵn.');
				return; // Ngăn không cho thực thi tiếp
			}

			$.ajax({
				url: '/addToCart.php',
				type: 'POST',
				data: {
					product_id: <?php echo json_encode($sanPham['id']); ?>,
					color: color,
					size: size,
					userSelectedQuantity: userSelectedQuantity
				},
				success: function(response) {
					var data = JSON.parse(response);
					if (data.success) {
						alert('Sản phẩm đã được thêm vào giỏ hàng.');
					} else {
						alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
					}
				}
			});
		});
	});
	
</script>
<script>
	document.getElementById('submit-comment').addEventListener('click', function() {
		var commentText = document.getElementById('comment-textarea').value;
		var productId = document.getElementById('maSanPham').value;

		if (commentText.trim() === '') {
			alert('Vui lòng nhập bình luận.');
			return;
		}

		var xhr = new XMLHttpRequest();
		xhr.open('POST', '/submit_comment.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);
				if (response.success) {
					var commentsDisplay = document.getElementById('comments-display');
					commentsDisplay.innerHTML += '<div><img src="' + response.userImage + '" class="rounded-circle mr-3" alt="Avatar" style="width: 40px; height: 40px;"><h6 class="mb-1">' + response.userName + '</h6><div class="text-muted" style="font-size: 0.8rem;"><em>' + response.createdAt + '</em></div><p class="mt-2">' + response.comment + '</p></div>';
					document.getElementById('comment-textarea').value = ''; // Clear the textarea after posting
				} else {
					alert('Lỗi: ' + response.error);
				}
			} else {
				alert('Có lỗi xảy ra khi gửi bình luận.');
			}
		};
		xhr.send('comment=' + encodeURIComponent(commentText) + '&MaSanPham=' + productId);
	});
</script>