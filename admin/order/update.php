<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $sanPham = loadOne_sanpham($_GET['id']);
    if (is_array($sanPham)) {
        extract($sanPham);
    }
}

$hinhpath = "upload/" . (isset($hinhAnh) ? $hinhAnh : 'default.png');
if (is_file($hinhpath)) {
    $hinh = "<img src='" . $hinhpath . "' height='80px'>";
} else {
    $hinh = "No Photo";
}

?>

<div class="container mt-4">
    <div class="row ">
        <div class="col">
            <h1>Cập nhật sản phẩm</h1>
        </div>
    </div>

    <form action="index.php?act=updatesp" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <select class="form-control" name="iddm">
                <option value="0" selected>Tất cả</option>
                <?php foreach ($listdm as $dm) : ?>
                    <?php $selected = ($iddm == $dm['id']) ? 'selected' : ''; ?>
                    <option value="<?= $dm['id'] ?>" <?= $selected ?>>
                        <?= $dm['TenDanhMuc'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tenSanPham">Tên sản phẩm</label>
            <input class="form-control" type="text" name="tenSanPham" id="" value="<?= $tenSanPham ?>">
            <?php if (!empty($error['tenSanPham'])) : ?>
                <div class="alert alert-danger"><?= $error['tenSanPham']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="gia">Giá</label>
            <input class="form-control" type="text" name="gia" id="" value="<?= $gia ?>">
            <?php if (!empty($error['gia'])) : ?>
                <div class="alert alert-danger"><?= $error['gia']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Mô tả</label><br>
            <textarea name="moTa" class="form-control" rows="3"><?= $moTa ?></textarea>
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Hình</label>
            <input class="form-control" type="file" name="hinhAnh" id="">
            <?= $hinh  ?>
            <?php if (!empty($error['hinhAnh'])) : ?>
                <div class="alert alert-danger"><?= $error['hinhAnh']; ?></div>
            <?php endif; ?>
        </div>


        <br>

        <div class="col-md-4 offset-md-0 mb-5">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input class="btn btn-primary" type="submit" name="capnhat" value="Cập nhật">
            <input class="btn btn-danger" type="reset" value="Nhập lại">
            <a href="index.php?act=listsp"><input class="btn btn-success" type="button" value="Danh sách"></a>
        </div>
        <?php
        if (isset($thongbao) && ($thongbao != ""))
            echo '<p style="color:green;">' . $thongbao . '</p>';
        ?>
    </form>

</div>