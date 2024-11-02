<div class="toolbox elemento_stick add_bottom_30">
    <div class="search-result-message">
        <?php if (!empty($searchResults)) : ?>
            <p class="text-muted">Tìm thấy <?= count($searchResults) ?> kết quả cho từ khóa "<strong><?= $keyword ?></strong>"</p>
        <?php else : ?>
            <p class="text-warning">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<strong><?= $keyword ?></strong>"</p>
        <?php endif; ?>
    </div>
    <div class="row small-gutters">
        <?php if (!empty($searchResults)) : ?>
            <?php foreach ($searchResults as $product) : ?>
                <div class="col-6 col-md-4 mb-4">
                    <div class="grid_item">
                        <figure>
                            <a href="index.php?act=spct&id=<?= $product['id'] ?>">
                                <img class="img-fluid lazy" src="<?= $img_path . $product['hinhAnh'] ?>" alt="<?= $product['tenSanPham'] ?>">
                            </a>
                        </figure>
                        <a href="index.php?act=spct&id=<?= $product['id'] ?>">
                            <h3 class="product_name"><?= $product['tenSanPham'] ?></h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price"><?= number_format($product['gia'], 0, ',', '.') ?> VND</span>
                        </div>
                       
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center w-100">Không có sản phẩm nào.</p>
        <?php endif; ?>
    </div>
    <div class="pagination__wrapper">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) : ?>
                <li class="page-item"><a href="index.php?act=search&keyword=<?= $keyword ?>&page=<?= $page - 1 ?>" class="page-link" title="Trang trước">&#10094;</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a href="index.php?act=search&keyword=<?= $keyword ?>&page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages) : ?>
                <li class="page-item"><a href="index.php?act=search&keyword=<?= $keyword ?>&page=<?= $page + 1 ?>" class="page-link" title="Trang sau">&#10095;</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
