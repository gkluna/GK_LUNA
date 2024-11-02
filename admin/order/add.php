<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1>Thêm mới sản phẩm</h1>
        </div>
    </div>

    <form action="index.php?act=addsp" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Danh mục</label>
            <select class="form-control" name="iddm">
                <?php foreach ($listdm as $dm) : ?>
                    <option value="<?= $dm['id']; ?>" <?= (isset($iddm) && $iddm == $dm['id']) ? 'selected' : ''; ?>>
                        <?= $dm['TenDanhMuc']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tenSanPham">Tên sản phẩm</label>
            <input class="form-control" type="text" name="tenSanPham" value="<?= isset($_POST['tenSanPham']) ? htmlspecialchars($_POST['tenSanPham']) : ''; ?>">
            <?php if (!empty($errors['tenSanPham'])) : ?>
                <div class="alert alert-danger"><?= $errors['tenSanPham']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="gia">Giá</label>
            <input class="form-control" type="text" name="gia" value="<?= isset($_POST['gia']) ? htmlspecialchars($_POST['gia']) : ''; ?>">
            <?php if (!empty($errors['gia'])) : ?>
                <div class="alert alert-danger"><?= $errors['gia']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="moTa">Mô tả</label><br>
            <textarea name="moTa" class="form-control" rows="3"><?= isset($_POST['moTa']) ? htmlspecialchars($_POST['moTa']) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="hinhAnh">Hình ảnh</label>
            <input class="form-control" type="file" name="hinhAnh">
            <?php if (!empty($errors['hinhAnh'])) : ?>
                <div class="alert alert-danger"><?= $errors['hinhAnh']; ?></div>
            <?php endif; ?>
        </div>

        <br>
        <div class="col-md-4 offset-md-0 mb-5">
            <input class="btn btn-primary" type="submit" name="themmoi" value="Thêm mới">
            <input class="btn btn-danger" type="reset" value="Nhập lại">
            <a href="index.php?act=listsp" class="btn btn-success">Danh sách</a>
        </div>
        <?php
        if (isset($thongbao) && ($thongbao != ""))
            echo '<p style="color:green;">' . $thongbao . '</p>';
        ?>
    </form>

</div>