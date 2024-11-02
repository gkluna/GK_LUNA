<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thêm Mới Tài Khoản</h3>
                </div>
            </div>
            <div class="card-body">
                <form action="index.php?act=addsp" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="iddm" class="form-label">Danh mục</label>
                        <select class="form-control" id="iddm" name="iddm">
                            <?php foreach ($listdm as $dm) : ?>
                                <option value="<?= $dm['id']; ?>" <?= (isset($iddm) && $iddm == $dm['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($dm['TenDanhMuc']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tenSanPham" class="form-label">Tên sản phẩm</label>
                        <input class="form-control" id="tenSanPham" type="text" name="tenSanPham" value="<?= isset($_POST['tenSanPham']) ? htmlspecialchars($_POST['tenSanPham']) : ''; ?>">
                        <?php if (!empty($errors['tenSanPham'])) : ?>
                            <div class="alert alert-danger"><?= $errors['tenSanPham']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="gia" class="form-label">Giá</label>
                        <input class="form-control" id="gia" type="text" name="gia" value="<?= isset($_POST['gia']) ? htmlspecialchars($_POST['gia']) : ''; ?>">
                        <?php if (!empty($errors['gia'])) : ?>
                            <div class="alert alert-danger"><?= $errors['gia']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="moTa" class="form-label">Mô tả</label>
                        <textarea id="moTa" name="moTa" class="form-control" rows="3"><?= isset($_POST['moTa']) ? htmlspecialchars($_POST['moTa']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="hinhAnh" class="form-label">Hình ảnh</label>
                        <input class="form-control" id="hinhAnh" type="file" name="hinhAnh">
                        <?php if (!empty($errors['hinhAnh'])) : ?>
                            <div class="alert alert-danger"><?= $errors['hinhAnh']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <input class="btn btn-primary me-md-2" type="submit" name="themmoi" value="Thêm mới">
                        <input class="btn btn-danger me-md-2" type="reset" value="Nhập lại">
                        <a href="index.php?act=listsp" class="btn btn-success">Danh sách sản phẩm</a>
                    </div>


                    <?php if (!empty($thongbao)) : ?>
                        <div class="alert alert-success"><?= $thongbao; ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>