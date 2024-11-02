<div class="bg_gray">
	<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
			</div>
			<h1>Thanh Toán Đơn Hàng</h1>
		</div>
		<!-- /page_header -->
		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-6">
				<div class="step first">
					<h3>Thông tin người nhận</h3>
					<div class="tab-content checkout">
						<div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="tab_1">
							<!-- Nếu người dùng đã đăng nhập, hiển thị thông tin người nhận từ session -->
							<?php if (isset($_SESSION['user']) && $_SESSION['user']) : ?>
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email*" value="<?php echo $_SESSION['user']['email']; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="">Họ và Tên</label>
									<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Họ Tên*" value="<?php echo $_SESSION['user']['fullname']; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="">Địa chỉ</label>
									<input type="text" class="form-control" name="address" id="address" placeholder="Địa chỉ*" value="<?php echo $_SESSION['user']['address']; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="">Sô điện thoại</label>
									<input type="text" class="form-control" name="phone" id="phone" placeholder="Số điện thoại *" value="<?php echo $_SESSION['user']['tel']; ?>" readonly>
								</div>
							<?php else : ?>
								<p>Bạn cần <a href="/login">đăng nhập</a> hoặc <a href="/register">đăng ký</a> để tiếp tục.</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<!-- /step -->
			</div>
			<div class="col-lg-4 col-md-8">
				<div class="step last">
					<h3>Thông tin đơn hàng</h3>
					<div class="box_general summary">
						<ul id="productList">
							<!-- JavaScript sẽ điền thông tin sản phẩm vào đây -->
						</ul>
						<div class="total clearfix">Tổng cộng <span id="totalPrice">$0.00</span></div>
						<form id="orderForm" action="index.php?act=confirm" method="post">
							<input type="hidden" name="productsData" id="productsData">
							<input type="hidden" name="totalCost" id="totalCost">
							<button type="submit" class="btn_1 full-width" id="confirmButton" data-logged-in="<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>">Xác nhận và Thanh toán</button>
						</form>
					</div>
				</div>
				<!-- /box_general -->
			</div>

			<!-- /step -->
		</div>
	</div>
	<!-- /row -->
</div>
<!-- /container -->
</div>
<style>
	.product-img {
		width: 70px;
		/* Tăng kích thước hình ảnh */
		height: auto;
		margin-right: 15px;
		/* Thêm khoảng cách giữa hình ảnh và thông tin sản phẩm */
	}

	.product-detail {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
		/* Thêm khoảng cách giữa các sản phẩm */
	}

	.product-info {
		flex-grow: 1;
	}

	.product-price {
		font-weight: bold;
	}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const selectedProducts = JSON.parse(sessionStorage.getItem('selectedProducts') || '[]');
		let total = 0;

		const productList = document.getElementById('productList');
		selectedProducts.forEach(product => {
			total += product.subtotal;
			const productItem = document.createElement('li');
			productItem.className = 'clearfix';
			productItem.innerHTML = `
            <div class="product-detail">
                <img src="${product.imageSrc}" alt="${product.name}" class="product-img">
                <div class="product-info">
                    <em>${product.name} - ${product.color}, ${product.size}, ${product.quantity} x </em>  <span>${product.subtotal} VNĐ</span>
                </div>
            </div>`;
			productList.appendChild(productItem);
		});

		document.getElementById('totalPrice').textContent = `${total} VNĐ`;
		document.getElementById('totalCost').value = total;

		if (selectedProducts.length === 0) {
			alert('Không có sản phẩm nào được chọn. Vui lòng chọn sản phẩm trước khi thanh toán.');
			
		}

		// Gán dữ liệu sản phẩm vào input ẩn
		document.getElementById('productsData').value = JSON.stringify(selectedProducts);

		const orderForm = document.getElementById('orderForm');
		orderForm.addEventListener('submit', function(event) {
			const isLoggedIn = document.getElementById('confirmButton').getAttribute('data-logged-in') === 'true';
			if (!isLoggedIn) {
				event.preventDefault(); // Ngăn chặn hành động mặc định của form
				alert('Bạn cần đăng nhập để tiếp tục.');
				window.location.href = 'index.php?act=dangnhap'; // Điều hướng người dùng đến trang đăng nhập
			}
		});
	});
</script>