<div class="container mt-4">
    <div class="car">
        <div class="card-header">
            <h1>Danh sách loại hàng</h1>
        </div>
    </div>
    <div class="card-body">
        <div class="col text-right">
            <a href="index.php?act=adddm" class="btn btn-primary">Nhập thêm</a>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Mã Loại</th>
                            <th>Tên Loại</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_dm as $danhmuc) : ?>
                            <?php
                            extract($danhmuc);
                            $suadm = "index.php?act=suadm&id=" . $id;
                            $xoadm = "index.php?act=xoadm&id=" . $id;
                            $thongbaoxoa = "Bạn có muốn xóa loại hàng: " . $TenDanhMuc . "?";
                            ?>
                            <tr class="text-center">
                                <td><?= $id ?></td>
                                <td><?= $TenDanhMuc ?></td>
                                <td>
                                    <a href="<?= $suadm ?>" class="btn btn-warning">Sửa</a>
                                    <a href="<?= $xoadm ?>" onclick="return confirm('<?= $thongbaoxoa ?>');" class="btn btn-danger">Xóa</a>
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
                                <li class="page-item"><a class="page-link" href="index.php?act=listdm&page=<?= $page - 1 ?>" title="Trang trước">&#10094;</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="index.php?act=listdm&page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?act=listdm&page=<?= $page + 1 ?>" title="Trang sau">&#10095;</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>