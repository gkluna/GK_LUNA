<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Danh sách sản phẩm</h2>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="index.php?act=listsp" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm sản phẩm" />
                    </div>
                    <div class="col">
                        <select name="danhMuc" class="form-control">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($danhMuc as $dm) : ?>
                                <option value="<?= $dm['id']; ?>"><?= $dm['TenDanhMuc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Thêm input ẩn để kiểm tra việc lọc trong logic xử lý -->
                    <input type="hidden" name="filter" value="1">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </form>

        </div>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col text-right">
                <a href="index.php?act=addsp" class="btn btn-secondary">Nhập thêm</a>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>MSP</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Hình ảnh</th>
                                <th>Số lượng</th>

                                <th>Loại</th>
                                <th>Thao tác</th>
                                <th>Biến thể</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listsanpham as $sanpham) : ?>
                                <?php
                                extract($sanpham);
                                $suasp = "index.php?act=suasp&id=" . $id;
                                $xoasp = "index.php?act=xoasp&id=" . $id;
                                $xembienthe = "index.php?act=listOne&MaSanPham=" . $id;
                                $thongbaoxoa = "'Bạn có muốn xóa sản phẩm: " . $tenSanPham . "?'";
                                $hinhpath = "upload/" . $hinhAnh;
                                $hinh = is_file($hinhpath) ? "<img src='" . $hinhpath . "' height='80px'>" : "No Photo";
                                ?>
                                <tr>
                                    <td><?= $id; ?></td>
                                    <td><?= $tenSanPham; ?></td>
                                    <td><?= $gia; ?></td>
                                    <td><?= $hinh; ?></td>
                                    <td><?= $tongSoLuong; ?></td>

                                    <td><?= $TenDanhMuc; ?></td>
                                    <td>
                                        <a href="<?= $suasp; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="<?= $xoasp; ?>" onclick="return confirm(<?= $thongbaoxoa; ?>);" class="btn btn-danger btn-sm">Xóa</a>
                                    </td>
                                    <td>
                                        <a href="<?= $xembienthe; ?>" class="btn btn-info btn-sm">Xem Biến Thể</a>
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
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1) : ?>
                                    <li class="page-item"><a href="index.php?act=listsp&page=<?= $page - 1; ?>" class="page-link">Trước</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a href="index.php?act=listsp&page=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages) : ?>
                                    <li class="page-item"><a href="index.php?act=listsp&page=<?= $page + 1; ?>" class="page-link">Sau</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>