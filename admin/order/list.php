<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1>Danh sách đơn hàng</h1>
        </div>
    </div>
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm đơn hàng</h6>
    </div>
    <div class="card-body">
        <form action="index.php?act=orders" method="POST" class="row gx-3 gy-2 align-items-center">
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    <input type="text" id="search_keyword" name="search_keyword" class="form-control" placeholder="Tên sản phẩm hoặc tên người dùng">
                </div>
            </div>
            <div class="col-sm-2">
                <select id="status" name="status" class="form-select">
                    <option value="">Chọn trạng thái</option>
                    <option value="choxuly">Chờ xử lý</option>
                    <option value="xacnhandon">Xác nhận đơn</option>
                    <option value="giaohang">Giao hàng</option>
                    <option value="giaohangthanhcong">Giao hàng thành công</option>
                    <option value="giaohangthatbai">Giao hàng thất bại</option>
                    <option value="huydon">Đơn bị hủy</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select id="price_range" name="price_range" class="form-select">
                    <option value="">Khoảng giá</option>
                    <option value="0-499999">Dưới 500k VNĐ</option>
                    <option value="500000-999999">500k - Dưới 1 tr VNĐ</option>
                    <option value="1000000-1999999">1 Tr - Dưới 2 VNĐ</option>
                    <option value="2000000+">Trên 2 Tr VNĐ</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select id="time_period" name="time_period" class="form-select" onchange="toggleDateInput(this.value)">
                    <option value="">Chọn thời gian</option>
                    <option value="today">Hôm nay</option>
                    <option value="this_week">Tuần này</option>
                    <option value="this_month">Tháng này</option>
                    <option value="this_year">Năm này</option>
                    <option value="custom">Tự chọn</option>
                </select>
            </div>
            <div class="col-sm-2" style="display: none;" id="custom_date_range">
                <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Từ ngày">
            </div>
            <div class="col-sm-2" style="display: none;" id="custom_date_range_end">
                <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Đến ngày">
            </div>
            <div class="col-sm-12 text-end mt-3">
                <button type="submit" name="filter" class="btn btn-primary">Tìm kiếm</button>
                <button type="reset" class="btn btn-secondary">Đặt lại</button>
            </div>
        </form>
    </div>
</div>



    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Mã đơn hàng</th>
                            <th class="text-center">Tên khách hàng</th>
                            <th class="text-center">Tổng giá</th>
                            <th class="text-center">Ngày tạo</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                            <th></th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_orders as $order) : ?>
                            <?php
                            $xemchitiet = "index.php?act=detail&MaDonHang=" . $order['MaDonHang'];
                            $update_action = "index.php?act=update_status"; // Đường dẫn có thể cần thay đổi
                            ?>
                            <tr>
                                <td class="text-center"><?= $order['MaDonHang']; ?></td>
                                <td><?= $order['fullName']; ?></td>
                                <td><?= number_format($order['TongGia'], 0, '.', ','); ?>vnđ</td>
                                <td class="text-center"><?= $order['NgayTao']; ?></td>
                                <td class="text-center"><?= $order['TrangThai']; ?></td>
                                <td class="text-center">
                                    <?php if (!in_array($order['TrangThai'], ['huydon', 'giaohangthanhcong', 'giaohangthatbai'])) : ?>
                                        <form action="<?= $update_action; ?>" method="POST" class="d-inline">
                                            <div class="input-group input-group-sm">
                                                <select name="new_status" class="form-select">
                                                    <?php switch ($order['TrangThai']) {
                                                        case 'choxuly':
                                                            echo '<option value="xacnhandon">Xác nhận đơn</option>';
                                                            echo '<option value="huydon">Hủy đơn</option>';
                                                            break;
                                                        case 'xacnhandon':
                                                            echo '<option value="giaohang">Giao hàng</option>';
                                                            break;
                                                        case 'giaohang':
                                                            echo '<option value="giaohangthanhcong">Giao hàng thành công</option>';
                                                            echo '<option value="giaohangthatbai">Giao hàng thất bại</option>';
                                                            break;
                                                    } ?>
                                                </select>
                                                <button class="btn btn-outline-primary" type="submit" name="update_status">
                                                    <i class="bi bi-arrow-up-circle-fill"></i> Cập nhật
                                                </button>
                                            </div>
                                            <input type="hidden" name="MaDonHang" value="<?= $order['MaDonHang']; ?>">
                                        </form>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= $xemchitiet; ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>



                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <?php if ($page > 1) : ?>
                                <li class="page-item"><a href="index.php?act=orders&page=<?= $page - 1; ?>" class="page-link">Trước</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a href="index.php?act=orders&page=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item"><a href="index.php?act=orders&page=<?= $page + 1; ?>" class="page-link">Sau</a></li>
                            <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .input-group-sm>.form-select,
    .input-group-sm>.form-control {
        padding: .25rem .5rem;
        font-size: .875rem;
        border-radius: .2rem;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    i.bi-arrow-up-circle-fill {
        margin-right: 5px;
    }
</style>
<script>
    function toggleDateInput(value) {
        var display = (value === 'custom') ? 'block' : 'none';
        document.getElementById('custom_date_range').style.display = display;
        document.getElementById('custom_date_range_end').style.display = display;
    }
</script>