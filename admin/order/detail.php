<div class="container mt-4">
<div class="car">
        <div class="card-header">
            <h1>Chi Tiết đơn hàng</h1>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <!-- Cột cho thông tin sản phẩm, nằm bên trái -->
                <div class="col-md-8">
                    <?php foreach ($details as $detail) : ?>
                        <div class="mb-4">
                            <div class="d-flex flex-row">
                                <!-- Hình ảnh và thông tin sản phẩm -->
                                <div class="flex-shrink-1 mr-3">
                                    <?php
                                    $imagePath = "upload/" . $detail['hinhAnh'];
                                    if (file_exists($imagePath) && is_file($imagePath)) {
                                        echo "<img src='$imagePath' alt='" . htmlspecialchars($detail['tenSanPham']) . "' style='width: 100px; height: auto;'>";
                                    }
                                    ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h5><?= htmlspecialchars($detail['tenSanPham']) ?></h5>
                                    <p>Size: <?= htmlspecialchars($detail['size']) ?>, Màu: <?= htmlspecialchars($detail['color']) ?></p>
                                    <p>Số lượng: <?= htmlspecialchars($detail['SoLuong']) ?></p>
                                    <p>Giá: <?= number_format($detail['gia']) ?> VND</p>
                                    <p><strong>Thành tiền: <?= number_format($detail['gia'] * $detail['SoLuong']) ?> VND</strong></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cột cho thông tin người mua, nằm bên phải -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Thông tin người mua</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Người mua hàng: <?= htmlspecialchars($details[0]['fullname']) ?></p>
                            <p class="card-text">Địa chỉ người nhận: <?= htmlspecialchars($details[0]['address'] ?? 'Không có') ?></p>
                            <p class="card-text">Số điện thoại: <?= htmlspecialchars($details[0]['tel'] ?? 'Không có') ?></p>
                            <p class="card-text"><strong>Tổng tiền thanh toán: <?= number_format(end($details)['TongGia']) ?> VND</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
