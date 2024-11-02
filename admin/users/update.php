<?php
if (isset($_GET['id_user']) && $_GET['id_user'] > 0) {
    $id_user = filter_input(INPUT_GET, 'id_user', FILTER_SANITIZE_NUMBER_INT);
    $user = loadOne_user($id_user);
    if (is_array($user)) {
        extract($user);
    }
}

$hinhpath = "upload/" . (isset($hinhAnh) ? htmlspecialchars($hinhAnh) : 'default.png');
if (is_file($hinhpath)) {
    $hinh = "<img src='" . htmlspecialchars($hinhpath) . "' height='80px'>";
} else {
    $hinh = "No Photo";
}
?>

<div class="container mt-5">
    <div class="row ">
        <div class="col">
            <h1 class="text-center">Cập nhật tài khoản người dùng</h1>
        </div>
    </div>

    <div class="card shadow mt-3">
        <div class="card-body">
            <form action="index.php?act=updateUser" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userName">Tên người dùng</label>
                    <input class="form-control" type="text" name="userName" id="userName" value="<?= htmlspecialchars($userName) ?>">
                    <?php if (!empty($errors['userName'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['userName']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
                    <?php if (!empty($errors['email'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['email']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="pass">Mật khẩu</label>
                    <input class="form-control" type="password" name="pass" id="pass" value="<?= htmlspecialchars($pass) ?>">
                    <?php if (!empty($errors['pass'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['pass']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input class="form-control" type="text" name="fullname" id="fullname" value="<?= htmlspecialchars($fullname) ?>">
                    <?php if (!empty($errors['fullname'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['fullname']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input class="form-control" type="text" name="address" id="address" value="<?= htmlspecialchars($address) ?>">
                    <?php if (!empty($errors['address'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['address']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="tel">Số điện thoại</label>
                    <input class="form-control" type="text" name="tel" id="tel" value="<?= htmlspecialchars($tel) ?>">
                    <?php if (!empty($errors['tel'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['tel']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Hình</label>
                    <input class="form-control-file" type="file" name="hinhAnh" id="exampleFormControlFile1">
                    <?= $hinh ?>
                    <?php if (!empty($errors['hinhAnh'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['hinhAnh']); ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="hinhAnhCu" value="<?= isset($hinhAnh) ? $hinhAnh : '' ?>">
                </div>
                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select class="form-control" name="role" id="role">
                        <option value="nguoidung" <?= (isset($role) && $role == 'nguoidung') ? 'selected' : '' ?>>Người dùng</option>
                        <option value="quantri" <?= (isset($role) && $role == 'quantri') ? 'selected' : '' ?>>Quản trị</option>
                    </select>
                    <?php if (!empty($errors['role'])) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['role']); ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="id_user" value="<?= $id_user ?>">
                        <input class="btn btn-primary" type="submit" name="capnhat" value="Cập nhật">
                        <input class="btn btn-danger" type="reset" value="Nhập lại">
                        <a href="index.php?act=listUsers" class="btn btn-success">Danh sách</a>
                    </div>
                </div>
                <?php
                if (isset($thongbao) && ($thongbao != ""))
                    echo '<div class="text-center mt-2"><p style="color:green;">' . htmlspecialchars($thongbao) . '</p></div>';
                ?>
            </form>
        </div>
    </div>
</div>
