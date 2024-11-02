<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thêm Mới Tài Khoản</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?act=addUser" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" name="userName" id="userName" placeholder="Tên đăng nhập*" value="<?= isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : ''; ?>">
                            <?php if (isset($errors['userName'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['userName']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email*" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            <?php if (isset($errors['email'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['email']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Mật khẩu*">
                            <?php if (isset($errors['pass'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['pass']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="re_pass" id="re_pass" placeholder="Nhập lại mật khẩu*">
                            <?php if (isset($errors['re_pass'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['re_pass']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Họ và tên*" value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                            <?php if (isset($errors['fullname'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['fullname']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address" placeholder="Địa chỉ*" value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                            <?php if (isset($errors['address'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['address']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" name="tel" id="tel" placeholder="Số điện thoại *" value="<?= isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : ''; ?>">
                            <?php if (isset($errors['tel'])) : ?>
                                <div class="text-danger"><?= htmlspecialchars($errors['tel']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input class="btn btn-primary" type="submit" name="themmoi" value="Thêm mới">
                            <input class="btn btn-secondary" type="reset" value="Nhập lại">
                            <a href="index.php?act=listUsers" class="btn btn-success">Danh sách</a>
                        </div>
                        <?php if (!empty($thongbao)) : ?>
                            <div class="alert alert-success"><?= $thongbao; ?></div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>