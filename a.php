<div class="prod_info">
	<h1><?php echo $sanPham['tenSanPham']; ?></h1>
	<span class="rating">
		<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
		<em>4 reviews</em>
	</span>
	<p><small>SKU: <?php echo $sanPham['id']; ?></small></p>
	<p><strong>Số lượng:</strong> <span id="quantityDisplay"><?php echo $sanPham['tongSoLuong'] > 0 ? $sanPham['tongSoLuong'] : 'Hết hàng'; ?></span></p>
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
			<div class="price_main"><span class="new_price">$<?php echo $sanPham['gia']; ?></span> <span class="old_price">$<?php echo $sanPham['gia_cu']; ?></span></div>
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
<script>
	document.addEventListener('DOMContentLoaded', function() {
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
					} else {
						$('#quantityDisplay').text('Hết hàng');
						addToCartButton.prop('disabled', true).addClass('disabled').text('Hết hàng');
					}
				}
			});
		}

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

		// Ngăn chặn sự kiện click trên nút "Hết hàng"
		$('#addToCartButton').click(function(event) {
			if ($(this).hasClass('disabled')) {
				event.preventDefault(); // Ngăn chặn sự kiện mặc định, ví dụ như chuyển hướng hoặc tải lại trang
				alert("Sản phẩm này hiện tại hết hàng."); // Hiển thị thông báo cho người dùng
			}
		});

	});
	var selectedColor = '';
	var selectedSize = $('#sizeSelect').val();

	$('.color').click(function(e) {
		e.preventDefault();
		$('.color').removeClass('selected');
		$(this).addClass('selected');
		selectedColor = $(this).data('color');
		updateQuantityAndAvailability(selectedColor, selectedSize);
	});

	$('#sizeSelect').change(function() {
		selectedSize = $(this).val();
		updateQuantityAndAvailability(selectedColor, selectedSize);
	});

	$('#addToCartButton').click(function() {
		var color = $('.color.active').data('color');
		var size = $('#sizeSelect').val();
		var quantity = parseInt($('#quantity_1').val());

		if (!color || !size || quantity <= 0) {
			alert('Vui lòng chọn đầy đủ màu sắc, kích thước và số lượng phải lớn hơn 0.');
			return; // Ngăn không cho thực thi tiếp
		}

		$.ajax({
			url: '/addToCart.php',
			type: 'POST',
			data: {
				product_id: <?php echo json_encode($sanPham['id']); ?>,
				color: color,
				size: size,
				quantity: quantity
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
</script>

<!-- <script>
	document.addEventListener('DOMContentLoaded', function() {
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
					} else {
						$('#quantityDisplay').text('Hết hàng');
						addToCartButton.prop('disabled', true).addClass('disabled').text('Hết hàng');
					}
				}
			});
		}

		$('.color').click(function(e) {
			e.preventDefault();
			var color = $(this).data('color');
			$('.color').removeClass('active');
			$(this).addClass('active');
			var size = $('#sizeSelect').val();
			updateQuantityAndAvailability(color, size);
		});

		$('#sizeSelect').change(function() {
			var size = $(this).val();
			var color = $('.color.active').data('color');
			updateQuantityAndAvailability(color, size);
		});

		$('#addToCartButton').click(function(event) {
			event.preventDefault();

			if ($(this).hasClass('disabled')) {
				alert("Sản phẩm này hiện tại hết hàng.");
				return;
			}

			var color = $('.color.active').data('color');
			if (!color) {
				alert("Vui lòng chọn màu sắc.");
				return;
			}

			var size = $('#sizeSelect').val();
			if (!size) {
				alert("Vui lòng chọn kích thước.");
				return;
			}

			var userSelectedQuantity = parseInt($('#quantity_1').val(), 10);
			if (isNaN(userSelectedQuantity) || userSelectedQuantity <= 0) {
				alert("Số lượng không hợp lệ. Vui lòng chọn một số lượng lớn hơn 0.");
				return;
			}

			$.ajax({
				url: '../index.php',
				type: 'POST',
				data: {
					action: 'addtocart',
					product_id: <?php echo json_encode($sanPham['id']); ?>,
					color: color,
					size: size,
					userSelectedQuantity: userSelectedQuantity // Đã sửa từ selectedQuantity thành userSelectedQuantity
				},
				dataType: 'json', // Thêm để đảm bảo phản hồi được xử lý như JSON
				success: function(response) {
					if (response.status === 'success') { // Sửa từ response.success thành response.status === 'success'
						alert("Sản phẩm đã được thêm vào giỏ hàng.");
					} else {
						alert("Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.");
					}
				},
				error: function() {
					alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại.");
				}
			});
		});

	});
</script> -->


<script>
	$(document).ready(function() {
		$('#totalPrice').text('0 VND');

		function updateTotal() {
			let total = 0;
			// Duyệt qua mỗi sản phẩm được chọn
			$('.itemCheck:checked').each(function() {
				const productId = $(this).data('product-id');
				const subtotal = parseFloat($('#subtotal_' + productId).text().replace(' VND', ''));
				total += subtotal;
			});
			$('#totalPrice').text(total + ' VND'); // Cập nhật tổng tiền
		}

		// Cập nhật tổng tiền khi số lượng thay đổi
		$('.quantity-plus, .quantity-minus').click(function() {
			const isAdding = $(this).hasClass('quantity-plus');
			const productId = $(this).data('product-id');
			let quantity = parseInt($('#quantity_' + productId).text());
			quantity = isAdding ? quantity + 1 : (quantity - 1 > 0 ? quantity - 1 : 1); // Đảm bảo số lượng tối thiểu là 1
			$('#quantity_' + productId).text(quantity);

			// Cập nhật tổng tiền của sản phẩm đó
			const price = parseFloat($('#price_' + productId).text().replace(' VND', ''));
			const subtotal = quantity * price;
			$('#subtotal_' + productId).text(subtotal + ' VND');

			updateTotal(); // Cập nhật tổng tiền toàn bộ
		});

		// Sự kiện khi chọn sản phẩm
		$('.itemCheck').change(function() {
			updateTotal();
		});

		// Chọn/tắt chọn tất cả
		$('#checkAll').click(function() {
			$('.itemCheck').prop('checked', $(this).prop('checked'));
			updateTotal();
		});
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-7 order-md-1">
			<h4 class="mb-3">Billing Address</h4>
			<form>
				<div class="row">
					<div class="col-md-6 mb-3">
						<input type="text" class="form-control" name="userName" id="user_name" placeholder="UserName*" value="<?= isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : ''; ?>">
						<?php if (isset($errors['userName'])) : ?>
							<div class="text-danger"><?= htmlspecialchars($errors['userName']); ?></div>
						<?php endif; ?>
					</div>
					<div class="col-md-6 mb-3">
						<input type="email" class="form-control" name="email" id="email" placeholder="Email*" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
						<?php if (isset($errors['email'])) : ?>
							<div class="text-danger"><?= htmlspecialchars($errors['email']); ?></div>
						<?php endif; ?>
					</div>
				</div>

				<div class="mb-3">
					<input type="password" class="form-control" name="pass" id="password_in" placeholder="Mật khẩu*">
					<?php if (isset($errors['pass'])) : ?>
						<div class="text-danger"><?= htmlspecialchars($errors['pass']); ?></div>
					<?php endif; ?>
				</div>

				<div class="mb-3">
					<input type="password" class="form-control" name="re_pass" id="confirm_password_in" placeholder="Nhập lại mật khẩu*">
					<?php if (isset($errors['re_pass'])) : ?>
						<div class="text-danger"><?= htmlspecialchars($errors['re_pass']); ?></div>
					<?php endif; ?>
				</div>

				<hr class="mb-4">
				<button class="btn btn-primary btn-lg btn-block" type="submit">Continue to Checkout</button>
			</form>
		</div>
		<div class="col-md-5 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="text-muted">Your Cart</span>
				<span class="badge badge-secondary badge-pill">3</span>
			</h4>
			<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed">
					<div>
						<h6 class="my-0">Product name</h6>
						<small class="text-muted">Brief description</small>
					</div>
					<span class="text-muted">$12</span>
				</li>
				<!-- More items here -->
				<li class="list-group-item d-flex justify-content-between">
					<span>Total (USD)</span>
					<strong>$20</strong>
				</li>
			</ul>
			<form class="card p-2">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Promo code">
					<div class="input-group-append">
						<button type="submit" class="btn btn-secondary">Redeem</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>