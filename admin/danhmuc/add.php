<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thêm Mới Danh Mục</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?act=adddm" method="post">
                        <div class="form-group">
                            <label for="TenDanhMuc">Tên Danh Mục</label>
                            <input type="text" class="form-control" name="TenDanhMuc" id="TenDanhMuc">
                            <?php if (isset($errors) && !empty($errors['TenDanhMuc'])) : ?>
                                <small class="form-text text-danger"><?php echo $errors['TenDanhMuc']; ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <input class="btn btn-primary" type="submit" name="themmoi" value="Thêm mới">
                            <input class="btn btn-secondary" type="reset" value="Nhập lại">
                            <a href="index.php?act=listdm" class="btn btn-success">Danh sách</a>
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
</div>