<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Bình Luận</h2>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="index.php?act=comment" method="POST" class="input-group mb-3">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm bình luận" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="filter"><i class="fas fa-search"></i> Tìm kiếm</button>
            </form>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row mb-2">

    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Tác giả</th>
                            <th>Nội dung</th>
                            <th>Ngày Tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) : ?>
                            <?php
                            extract($comment);
                            $xoacm = "index.php?act=xoacm&MaDanhGia=" . $MaDanhGia;
                            $thongbaoxoa = "'Bạn có muốn xóa đánh giá của người dùng: " . $fullName . "?'";
                            ?>
                            <tr>
                                <td><?= $MaDanhGia ?></td>
                                <td><?= $tenSanPham; ?></td>
                                <td><?= $fullName; ?></td>
                                <td><?= $BinhLuan; ?></td>
                                <td><?= $NgayTao; ?></td>


                                <td>

                                    <a href="<?= $xoacm; ?>" onclick="return confirm(<?= $thongbaoxoa; ?>);" class="btn btn-danger btn-sm">Xóa</a>
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
                                <li class="page-item"><a href="index.php?act=comment&page=<?= $page - 1; ?>" class="page-link">Trước</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a href="index.php?act=comment&page=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item"><a href="index.php?act=comment&page=<?= $page + 1; ?>" class="page-link">Sau</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>