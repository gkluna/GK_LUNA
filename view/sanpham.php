<div>
	<div class="container margin_30">
		<div class="row">
			<aside class="col-lg-3" id="sidebar_fixed">
				<form action="index.php?act=sanpham" method="POST">
					<div class="filter_col">
						<div class="inner_bt"><a href="#" class="open_filters"><i class="ti-close"></i></a></div>
						<div class="filter_type version_2">
							<h4><a href="#filter_1" data-bs-toggle="collapse" class="opened">Danh Mục</a></h4>
							<div class="collapse show" id="filter_1">
								<ul>
									<?php
									foreach ($categories as $category) {
										echo '<li>';
										echo '<label class="container_check">' . $category['TenDanhMuc'];
										echo '<input type="checkbox" name="category[]" value="' . $category['id'] . '">';
										echo '<span class="checkmark"></span>';
										echo '</label>';
										echo '</li>';
									}
									?>
								</ul>
							</div>
							<!-- /filter_type -->
						</div>
						<!-- /filter_type -->
						<div class="filter_type version_2">
							<h4><a href="#filter_3" data-bs-toggle="collapse" class="opened">Giá</a></h4>
							<div class="collapse show" id="filter_3">
								<ul>
									<li>
										<label class="container_check">0 — 299999
											<input type="radio" name="price_range" value="0-299999">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">300000-499999
											<input type="radio" name="price_range" value="300000-499999">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">500000 — 999999
											<input type="radio" name="price_range" value="500000-999999">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">1000000 — 2000000
											<input type="radio" name="price_range" value="1000000-2000000">
											<span class="checkmark"></span>
										</label>
									</li>
									
								</ul>
							</div>
						</div>
						<!-- /filter_type -->
						<div class="filter_type version_2">
							<h4><a href="#filter_4" data-bs-toggle="collapse" class="opened">Sắp xếp theo giá</a></h4>
							<div class="collapse show" id="filter_4">
								<ul>
									<li>
										<label class="container_check">Tăng dần
											<input type="radio" name="price_sort" value="ASC">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Giảm dần
											<input type="radio" name="price_sort" value="DESC">
											<span class="checkmark"></span>
										</label>
									</li>
								</ul>
							</div>
						</div>
						<div class="buttons">
							<input type="submit" name="timkiem" value="Tìm kiếm">
							<input type="reset" value="Đặt lại">
						</div>
					</div>
				</form>
			</aside>
			<!-- /col -->
			<div class="col-lg-9">
				
				<!-- /top_banner -->
				<div id="stick_here"></div>
				<div class="toolbox elemento_stick add_bottom_30">
					<div class="row small-gutters">
						<?php
						if (!empty($products)) {
							foreach ($products as $product) {
								extract($product);
								$linksp = "index.php?act=spct&id=" . $product['id'];
								$hinh = $img_path . $hinhAnh;
								echo '<div class="col-6 col-md-4">';
								echo '    <div class="grid_item">';

								echo '        <figure>';
								echo '            <a href="' . $linksp . '">'; 
								echo '                <img class="img-fluid lazy" src="' . $hinh . '"  alt="' . $product['tenSanPham'] . '">';
								echo '            </a>';
								echo '        </figure>';
								echo '        <a href="' . $linksp . '">';
								echo '            <h3>' . $product['tenSanPham'] . '</h3>';
								echo '        </a>';
								echo '        <div class="price_box">';

								echo '            <span class="new_price">' . $product['gia'] . ' VND</span>';
								// if (!empty($product['gia'])) {
								// 	echo '        <span class="old_price">' . $product['gia'] . '</span>';
								// }
								echo '        </div>';
								echo '
								
								';
								echo '    </div>';
								echo '</div>';
							}
						} else {
							echo '<p>Không có sản phẩm nào.</p>';
						}
						?>;


						<!-- /col -->
					</div>
					<!-- /row -->
					<div class="pagination__wrapper">
						<ul class="pagination">
							<?php if ($page > 1) : ?>
								<li><a href="index.php?act=sanpham&page=<?= $page - 1 ?>" class="prev" title="Trang trước">&#10094;</a></li>
							<?php endif; ?>

							<?php for ($i = 1; $i <= $totalPages; $i++) : ?>
								<li <?php if ($page == $i) echo 'class="active"'; ?>><a href="index.php?act=sanpham&page=<?= $i; ?>"><?= $i; ?></a></li>
							<?php endfor; ?>

							<?php if ($page < $totalPages) : ?>
								<li><a href="index.php?act=sanpham&page=<?= $page + 1 ?>" class="next" title="Trang sau">&#10095;</a></li>
							<?php endif; ?>
						</ul>
					</div>

				</div>

				<!-- /col -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>