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
					<h3 class="client">Khách Hàng</h3>
					<div class="form_container">
						<form action="index.php?act=dangnhap" method="POST">
							<div class="form-group">
								<input type="email" class="form-control" name="email" id="email" placeholder="Email*" required>
								<!-- Hiển thị thông báo lỗi email -->
								<?php if (!empty($emailError)) : ?>
									<div class="error"><?php echo $emailError; ?></div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="pass" id="pass" placeholder="Password*" required>
								<!-- Hiển thị thông báo lỗi mật khẩu -->
								<?php if (!empty($passwordError)) : ?>
									<div class="error"><?php echo $passwordError; ?></div>
								<?php endif; ?>
							</div>
							<div class="clearfix add_bottom_15">
								
								<div class="float-end"><a id="forgot" href="javascript:void(0);">Quên Mật Khẩu?</a></div>
							</div>
							<?php if (!empty($generalError)) : ?>
								<div class="error"><?php echo $generalError; ?></div>
							<?php endif; ?>
							<div class="text-center"><input type="submit" name="dangnhap" value="Đăng Nhập" class="btn_1 full-width"></div>
							<p>Bạn chưa có tài khoản ? <a href="index.php?act=register" >Đăng ký ngay</a></p>
						</form>

						<div id="forgot_pw">
							<form action="index.php?act=quenmatkhau" method="POST">
								<div class="form-group">
									<input type="email" class="form-control" name="email_forgot" id="email_forgot" placeholder="Email của bạn" required>
								</div>
								<p>Mật khẩu mới sẽ sớm được gửi.</p>
								<div class="text-center"><input type="submit" name="guiemail" value="Reset Password" class="btn_1"></div>
								<?php if (isset($sendMailMess) && $sendMailMess != '') : ?>
									<div class="alert alert-success" role="alert">
										<?php echo $sendMailMess; ?>
									</div>
								<?php endif; ?>
							</form>
						</div>

					</div>
				</div>

				<!-- /box_account -->

			</div>
			
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>