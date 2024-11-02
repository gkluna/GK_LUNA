<?php 
if (isset($_GET['id']) && ($_GET['id'] > 0)) {
    $dm = loadOne_danhmuc($_GET['id']);
    if(is_array($dm)) {
        extract($dm);
}
}

?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1>Cập nhật danh mục</h1>
        </div>
    </div>
    <form action="index.php?act=updatedm" method="post" class="mt-3">
        <div class="form-group">
            <label for="TenDanhMuc">Tên Danh Mục</label>
            <input type="text" class="form-control" name="TenDanhMuc" id="TenDanhMuc" value="<?php echo isset($TenDanhMuc) ? htmlspecialchars($TenDanhMuc) : ''; ?>">
            <?php if (isset($errors['TenDanhMuc'])): ?>
                <div class="alert alert-danger mt-2"><?php echo $errors['TenDanhMuc']; ?></div>
            <?php endif; ?>
        </div>
        <input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>">
        <div class="form-group mt-4">
            <button type="submit" name="capnhat" class="btn btn-primary">Cập nhật</button>
            <button type="reset" class="btn btn-secondary">Nhập lại</button>
            <a href="index.php?act=listdm" class="btn btn-success">Danh sách</a>
        </div>
        <?php if (isset($thongbao) && !empty($thongbao)): ?>
            <div class="alert alert-success"><?php echo $thongbao; ?></div>
        <?php endif; ?>
    </form>
</div>
