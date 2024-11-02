<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $sanPham = loadOne_sanpham($_GET['id']);
    if (is_array($sanPham)) {
        extract($sanPham);
    }
} else {
    // Redirect hoặc xử lý nếu ID không hợp lệ
    // header('Location: index.php?act=listsp');
    // exit();
}

$hinhpath = "upload/" . (isset($hinhAnh) ? $hinhAnh : 'default.png');
if (is_file($hinhpath)) {
    $hinh = "<img src='" . $hinhpath . "' height='80px'>";
} else {
    $hinh = "No Photo";
}

// Giả sử bạn đã load danh sách danh mục vào $listdm ở đây
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
                <?php foreach ($listdm as $dm) : ?>
                    <?php $selected = (isset($iddm) && $iddm == $dm['id']) ? 'selected' : ''; ?>
                    <option value="<?= $dm['id'] ?>" <?= $selected ?>>
                        <?= $dm['TenDanhMuc'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tenSanPham">Tên sản phẩm</label>
            <input class="form-control" type="text" name="tenSanPham" id="tenSanPham" value="<?= isset($tenSanPham) ? $tenSanPham : '' ?>">
            <?php if (!empty($error['tenSanPham'])) : ?>
                <div class="alert alert-danger"><?= $error['tenSanPham']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="gia">Giá</label>
            <input class="form-control" type="text" name="gia" id="gia" value="<?= isset($gia) ? $gia : '' ?>">
            <?php if (!empty($error['gia'])) : ?>
                <div class="alert alert-danger"><?= $error['gia']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="moTa">Mô tả</label><br>
            <textarea name="moTa" class="form-control" rows="3"><?= isset($moTa) ? $moTa : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="hinhAnh">Hình</label>
            <input class="form-control" type="file" name="hinhAnh" id="hinhAnh">
            <?= $hinh ?>
            <?php if (!empty($error['hinhAnh'])) : ?>
                <div class="alert alert-danger"><?= $error['hinhAnh']; ?></div>
            <?php endif; ?>
            <!-- Gửi tên hình ảnh cũ qua form -->
            <input type="hidden" name="hinhAnhCu" value="<?= isset($hinhAnh) ? $hinhAnh : '' ?>">
        </div>

        <br>

        <div class="col-md-4 offset-md-0 mb-5">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input class="btn btn-primary" type="submit" name="capnhat" value="Cập nhật">
            <input class="btn btn-danger" type="reset" value="Nhập lại">
            <a href="index.php?act=listsp" class="btn btn-success">Danh sách</a>
        </div>
        <?php
        if (isset($thongbao) && ($thongbao != "")) {
            echo '<p style="color:green;">' . $thongbao . '</p>';
        }
        ?>
    </form>

</div>
