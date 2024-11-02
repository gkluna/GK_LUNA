<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4 mb-3">Chi tiết sản phẩm</h1>
            <div class="mb-3">
                
                <a href="index.php?act=addvariant&MaSanPham=<?php echo $MaSanPham; ?>" class="btn btn-primary float-right">Nhập thêm biến thể</a>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Màu Sắc</th>
                        <th>Kích Cỡ</th>
                        <th>Số Lượng</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($listOne as $bienthe) {
                        extract($bienthe);
                        $suabt = "index.php?act=suavariant&MaBienThe=" . $MaBienThe;
                        $xoabt = "index.php?act=xoavariant&MaBienThe=" . $MaBienThe;
                        $thongbaoxoa = "Bạn có muốn xóa biến thể này?";

                        echo '<tr>
                            <td>' . $tenSanPham . '</td>
                            <td>' . $color . '</td>
                            <td>' . $size . '</td>
                            <td>' . $quantity . '</td>
                            <td class="text-center">
                                <a href="' . $suabt . '" class="btn btn-primary btn-sm">Sửa</a>
                                <a href="' . $xoabt . '" class="btn btn-danger btn-sm" onclick="return confirm(\'' . $thongbaoxoa . '\');">Xóa</a>
                            </td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="index.php?act=listOne&MaSanPham=<?= $MaSanPham ?>&page=<?= $page - 1 ?>" title="Trang trước">&#10094;</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="index.php?act=listOne&MaSanPham=<?= $MaSanPham ?>&page=<?= $i; ?>"><?= $i; ?></a></li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item"><a class="page-link" href="index.php?act=listOne&MaSanPham=<?= $MaSanPham ?>&page=<?= $page + 1 ?>" title="Trang sau">&#10095;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>