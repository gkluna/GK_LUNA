<div class="bg_gray">
	<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="index.php">Trang chủ</a></li>
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
			</div>
			<h1>Cart page</h1>
		</div>
		<div class="table-responsive">
			<table class="table table-striped cart-list">
				<thead>
					<tr>

						<th class="text-center">Tên Sản Phẩm</th>
						<th class="text-center">Giá</th>
						<th class="text-center">Màu</th>
						<th class="text-center">Kích cỡ</th>
						<th class="text-center">Số lượng</th>
						<th class="text-center">Tổng tiền</th>
						<th class="text-center"></th>
						<th class="text-center">
							<div class="form-check">
								<input type="checkbox" id="checkAll" class="form-check-input" />
							</div>
						</th>

					</tr>
				</thead>
				<tbody>
					<?php
					$totalPrice = 0;
					if (!empty($_SESSION['cartItems'])) :
						foreach ($_SESSION['cartItems'] as $item) :
							$subtotal = $item['gia'] * $item['userSelectedQuantity'];
							$totalPrice += $subtotal;
					?>

							<tr>
								<td>
									<div class="thumb_cart">
										<?php
										$imagePath = "admin/upload/" . $item['hinhAnh'];
										if (file_exists($imagePath) && is_file($imagePath)) {
											echo "<img src='$imagePath' alt='Image' style='height: 80px;'>";
										}
										?>
									</div>
									<span class="item_cart"><?php echo $item['tenSanPham']; ?></span>
								</td>
								<td class="text-center">
									<strong id="price_<?php echo $item['MaBienThe']; ?>"><?php echo $item['gia']; ?> VND</strong>
								</td>
								<td class="text-center"><?php echo $item['color']; ?></td>
								<td><?php echo $item['size']; ?></td>
								<td>
									<div class="input-group input-group-sm mb-3" style="width: 120px; margin-left:40px ">
										<div class="input-group-prepend">
											<button class="btn btn-outline-secondary btn-sm quantity-minus" type="button" data-product-id="<?php echo $item['MaBienThe']; ?>" data-color="<?php echo $item['color']; ?>" data-size="<?php echo $item['size']; ?>" data-stock-quantity="<?php echo $item['quantity']; ?>">-</button>
										</div>
										<span id="quantity_<?php echo $item['MaBienThe']; ?>" class="quantity-display mx-2">
											<?php echo $item['userSelectedQuantity']; ?>
										</span>
										<div class="input-group-append">
											<button class="btn btn-outline-secondary btn-sm quantity-plus" type="button" data-product-id="<?php echo $item['MaBienThe']; ?>" data-color="<?php echo $item['color']; ?>" data-size="<?php echo $item['size']; ?>" data-stock-quantity="<?php echo $item['quantity']; ?>">+</button>
										</div>
									</div>
								</td>
								<td>
									<strong id="subtotal_<?php echo $item['MaBienThe']; ?>"><?php echo $subtotal; ?> VND</strong>
								</td>
								<td class="options">
									<a href="#" class="delete-item" data-mabienthe="<?php echo $item['MaBienThe']; ?>">Xóa</a>
								</td>
								<td class="text-center">
									<div class="form-check">
										<input type="checkbox" class="form-check-input itemCheck" data-product-id="<?php echo $item['MaBienThe']; ?>" data-color="<?php echo $item['color']; ?>" data-size="<?php echo $item['size']; ?>">
										
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">Your cart is empty.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="box_cart">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-md-6">
                        <!-- Nút Tiếp tục mua hàng -->
                        <a href="index.php?act=sanpham" class="btn_1 cart" style="width: 100%;">Tiếp tục mua hàng</a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul>
                            <li>
                                <span>Tổng tiền </span> <div id="totalPrice"><?php echo $totalPrice; ?> VND</div>
                            </li>
                        </ul>
                        <!-- Nút Thanh toán -->
                        <a href="index.php?act=checkout" id="checkoutButton" class="btn_1 full-width cart">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>

	</div>
</div>
<script>
	$(document).ready(function() {
		// Cập nhật tổng tiền khi trang tải xong
		updateTotal();

		// Hàm cập nhật tổng tiền dựa trên các sản phẩm được chọn
		function updateTotal() {
			let total = 0;
			// Duyệt qua tất cả các checkbox đã được chọn
			$('.itemCheck:checked').each(function() {
				const productId = $(this).data('product-id'); // Lấy ID sản phẩm từ data attribute
				const subtotal = parseFloat($('#subtotal_' + productId).text().replace(' VND', '')); // Lấy giá trị subtotal và chuyển đổi sang số
				total += subtotal; // Cộng dồn vào tổng tiền
			});
			$('#totalPrice').text(total + ' VND'); // Cập nhật tổng tiền trên giao diện
		}

		// Hàm gửi yêu cầu cập nhật số lượng sản phẩm
		function updateProductQuantity(MaBienThe, quantity) {
			$.ajax({
				url: '../update_quantity.php', // URL tới script xử lý cập nhật số lượng trên server
				type: 'POST',
				data: {
					MaBienThe: MaBienThe,
					newQuantity: quantity
				},
				success: function(response) {
					console.log("Cập nhật thành công:", response);
					updateTotal(); // Cập nhật lại tổng tiền sau khi cập nhật số lượng
				},
				error: function(xhr, status, error) {
					console.error("Có lỗi xảy ra khi cập nhật số lượng:", error);
				}
			});
		}

		// Xử lý sự kiện khi nút tăng/giảm số lượng được click
		$('.quantity-plus, .quantity-minus').click(function() {
			const isAdding = $(this).hasClass('quantity-plus'); // Kiểm tra nếu đây là nút tăng số lượng
			const productId = $(this).data('product-id'); // Lấy ID sản phẩm(id biến thể)
			const stockQuantity = $(this).data('stock-quantity'); // Lấy số lượng tồn kho
			let quantity = parseInt($('#quantity_' + productId).text()); // Lấy số lượng hiện tại và chuyển đổi sang số nguyên
			// Tăng hoặc giảm số lượng, đảm bảo số lượng không nhỏ hơn 1
			if (isAdding) {
				if (quantity < stockQuantity) {
					quantity += 1;
				} else {
					alert('Số lượng sản phẩm vượt quá số lượng tồn kho!');
					return; // Thoát khỏi hàm nếu không thể tăng thêm
				}
			} else {
				quantity = quantity - 1 > 0 ? quantity - 1 : 1;
			}
			$('#quantity_' + productId).text(quantity); // Cập nhật số lượng trên giao diện

			const price = parseFloat($('#price_' + productId).text().replace(' VND', '')); // Lấy giá sản phẩm và chuyển đổi sang số
			const subtotal = quantity * price; // Tính toán lại subtotal
			$('#subtotal_' + productId).text(subtotal + ' VND'); // Cập nhật subtotal trên giao diện

			updateProductQuantity(productId, quantity); // Gọi AJAX để cập nhật số lượng trong session
		});

		// Xử lý sự kiện khi thay đổi trạng thái của checkbox
		$('.itemCheck').change(function() {
			updateTotal(); // Cập nhật tổng tiền khi có sự thay đổi
		});

		// Xử lý sự kiện khi click vào "Chọn tất cả"
		$('#checkAll').click(function() {
			$('.itemCheck').prop('checked', $(this).prop('checked')); // Đồng bộ trạng thái của tất cả checkbox với checkbox "Chọn tất cả"
			updateTotal(); // Cập nhật tổng tiền
		});

		// Xử lý sự kiện khi click vào nút "Xóa"
		$('.delete-item').click(function(e) {
			e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết (không chuyển trang)
			const MaBienThe = $(this).data('mabienthe'); // Lấy MaBienThe từ data attribute
			const isConfirmed = confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?');
			if (!isConfirmed) {
				return; // Nếu người dùng chọn "Cancel", hủy bỏ hành động xóa
			}
			const row = $(this).closest('tr'); // Tìm dòng chứa sản phẩm

			// Gửi yêu cầu AJAX để xóa sản phẩm khỏi session hoặc database
			$.ajax({
				url: '../delete_cart.php', // URL tới script xử lý xóa
				type: 'POST',
				data: {
					MaBienThe: MaBienThe // Gửi MaBienThe như là dữ liệu POST
				},
				success: function(response) {
					console.log("Xóa thành công:", response);
					row.remove(); // Xóa dòng chứa sản phẩm khỏi giao diện
					updateTotal(); // Cập nhật lại tổng tiền
				},
				error: function(xhr, status, error) {
					console.error("Có lỗi xảy ra khi xóa sản phẩm:", error);
				}
			});
		});
		$('#checkoutButton').on('click', function(e) {
			e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

			// Thu thập thông tin sản phẩm đã chọn
			const selectedProducts = $('.itemCheck:checked').map(function() {
				// Lấy dòng chứa sản phẩm
				const row = $(this).closest('tr');

				// Xác định các giá trị từ cấu trúc HTML của mỗi sản phẩm
				const imageSrc = row.find('.thumb_cart img').attr('src');
				const name = row.find('.item_cart').text();
				const price = row.find('td:nth-child(2) strong').text().replace(' VND', '');
				const color = row.find('td:nth-child(3)').text();
				const size = row.find('td:nth-child(4)').text();
				const quantity = parseInt(row.find('.quantity-display').text());
				const subtotal = row.find('td:nth-child(6) strong').text().replace(' VND', '');

				return {
					productId: $(this).data('product-id'),
					name: name,
					imageSrc: imageSrc,
					color: color,
					size: size,
					quantity: quantity,
					price: parseFloat(price.replace(/,/g, '')), // Chuyển đổi giá thành số và loại bỏ dấu phẩy nếu có
					subtotal: parseFloat(subtotal.replace(/,/g, '')) // Chuyển đổi tổng phụ thành số và loại bỏ dấu phẩy nếu có
				};
			}).get();

			if (selectedProducts.length > 0) {
				// Lưu trữ dữ liệu sản phẩm vào sessionStorage (hoặc localStorage)
				sessionStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));

				// Chuyển hướng người dùng đến trang checkout
				window.location.href = 'index.php?act=checkout';
			} else {
				alert('Vui lòng chọn ít nhất một sản phẩm trước khi thanh toán!');
			}
		});




	});
</script>