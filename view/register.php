
<div class="bg_gray">

    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php?act=acc">Tài khoản</a></li>
                </ul>
            </div>
            <h1>Đăng nhập</h1>
        </div>
        <!-- /page_header -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="box_account">
                    <form action="index.php?act=register" method="POST">
                        <h3 class="new_client">ĐĂNG KÝ MỚI</h3> <small class="float-right pt-2">* Bắt buộc</small>
                        <div class="form_container">

                            <div class="form-group">
                                <input type="text" class="form-control" name="userName" id="user_name" placeholder="UserName*" value="<?= isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : ''; ?>">
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
                                <input type="password" class="form-control" name="pass" id="password_in" placeholder="Mật khẩu*">
                                <?php if (isset($errors['pass'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['pass']); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="re_pass" id="confirm_password_in" placeholder="Nhập lại mật khẩu*">
                                <?php if (isset($errors['re_pass'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['re_pass']); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" placeholder="Họ Tên*" value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                                <?php if (isset($errors['fullname'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['fullname']); ?></div>
                                <?php endif; ?>
                            </div>


                            <div class="form-group">
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ*" value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                                <?php if (isset($errors['address'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['address']); ?></div>
                                <?php endif; ?>
                            </div>


                            <div class="form-group">
                                <input type="text" class="form-control" name="tel" placeholder="Số điện thoại *" value="<?= isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : ''; ?>">
                                <?php if (isset($errors['tel'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['tel']); ?></div>
                                <?php endif; ?>
                            </div>

                            <?php if (isset($thongbao)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= htmlspecialchars($thongbao); ?>
                                </div>
                            <?php endif; ?>

                            <div class="text-center"><input type="submit" value="Đăng ký" class="btn_1 full-width" name="themmoi"></div>
                            <div class="text-center"><a href="index.php?act=dangnhap" class="btn_1 full-width" >Đăng Nhập</a></div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>