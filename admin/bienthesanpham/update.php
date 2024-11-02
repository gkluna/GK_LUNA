<?php
if (is_array($bienthe)) {
    extract($bienthe);
} ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Cập nhật biến thể</h3>
            </div>

            <div class="card-body">

                <form action="index.php?act=updatevariant&MaBienThe=<?php echo $MaBienThe; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="color">Màu sắc</label>
                        <input class="form-control" type="text" name="color" value="<?php echo $color; ?>">
                        <?php if (isset($errors['color'])) : ?>
                            <div class="text-danger"><?php echo $errors['color']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="size">Kích thước</label>
                        <input class="form-control" type="text" name="size" value="<?php echo $size; ?>">
                        <?php if (isset($errors['size'])) : ?>
                            <div class="text-danger"><?php echo $errors['size']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Số lượng</label>
                        <input class="form-control" type="number" name="quantity" value="<?php echo $quantity; ?>">
                        <?php if (isset($errors['quantity'])) : ?>
                            <div class="text-danger"><?php echo $errors['quantity']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 offset-md-0 mb-5">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input class="btn btn-primary" type="submit" name="capnhat" value="Cập nhật">
                        <input class="btn btn-danger" type="reset" value="Nhập lại">
                        <a href="index.php?act=listOne&MaSanPham=<?php echo $MaSanPham; ?>"><input class="btn btn-success" type="button" value="Danh sách"></a>
                    </div>
                    <?php if (isset($thongbao) && ($thongbao != "")) : ?>
                        <div class="alert alert-success mt-3" role="alert">
                            <?php echo $thongbao; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
