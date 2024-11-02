<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1>Danh sách tài khoản</h1>
        </div>
        <div class="col text-right">
            <a href="index.php?act=addUser" class="btn btn-secondary">Nhập thêm</a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id_User</th>
                            <th>User Name</th>
                            <th>Hình Ảnh</th>
                            <th>Email</th>
                            <th>Họ và tên</th>

                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_users as $users) : ?>
                            <?php
                            extract($users);
                            $suaUser = "index.php?act=suaUser&id_user=" . $id_user;
                            $xoaUser = "index.php?act=xoaUser&id_user=" . $id_user;
                            $thongbaoxoa = "'Bạn có muốn xóa sản phẩm: " . $userName . "?'";
                            $hinhpath = "upload/" . $hinhAnh;
                            $hinh = is_file($hinhpath) ? "<img src='" . $hinhpath . "' height='80px'>" : "No Photo";
                            ?>
                            <tr>
                                <td><?= $id_user; ?></td>
                                <td><?= $userName; ?></td>
                                <td><?= $hinh; ?></td>
                                <td><?= $email; ?></td>
                                <td><?= $fullname; ?></td>

                                <td><?= $address; ?></td>
                                <td><?= $tel; ?></td>
                                <td><?= $role; ?></td>

                                <td>
                                    <a href="<?= $suaUser; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <?php if ($role !== "quantri") : ?>
                                        <a href="<?= $xoaUser; ?>" onclick="return confirm(<?= $thongbaoxoa; ?>);" class="btn btn-danger btn-sm">Xóa</a>
                                    <?php endif; ?>
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
                                <li class="page-item"><a href="index.php?act=listUsers&page=<?= $page - 1; ?>" class="page-link">Trước</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>"><a href="index.php?act=listUsers&page=<?= $i; ?>" class="page-link"><?= $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item"><a href="index.php?act=listUsers&page=<?= $page + 1; ?>" class="page-link">Sau</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>