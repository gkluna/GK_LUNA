<div class="container py-5">
    <div class="row">
        <!-- Left side - User Information -->
        <div class="col-md-4">
            <?php foreach ($profile as $pro) : ?>
                <div class="card">
                    <?php
                    $imagePath = "admin/upload/" . $pro['hinhAnh'];
                    // Gọi hàm để kiểm tra và trả về đường dẫn hình ảnh
                    $imageSrc = getImagePath($imagePath);
                    echo "<img src='{$imageSrc}' class='card-img-top' alt='User Image'>";
                    ?>

                    <div class="card-body">
                        <h5 class="card-title"><?= $pro['userName'] ?></h5>
                        <p class="card-text"><?= $pro['fullname'] ?></p>
                        <p class="card-text"><?= $pro['email'] ?></p>
                        <p class="card-text"><?= $pro['tel'] ?></p>
                        <p class="card-text"><?= $pro['address'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="list-group mt-3">
                <a href="#" class="list-group-item list-group-item-action active">Đơn hàng của tôi</a>
                <a href="#" class="list-group-item list-group-item-action">Lịch sử mua hàng</a>
            </div>
        </div>
        <!-- Right side - Orders -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <!-- Sử dụng dữ liệu-toggle và dữ liệu-target để chỉ định mục tiêu xổ xuống -->
                    <a href="#orderDetails" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="orderDetails">
                        Đơn hàng gần đây
                    </a>
                </div>
                <!-- Collapse div, mặc định là ẩn và sẽ hiện ra khi người dùng nhấp vào "Đơn hàng gần đây" -->
                <div class="collapse" id="orderDetails" class="recentOrders">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item order-status" data-id_user="<?php echo $pro['id_user'] ?>" data-status="giaohangthanhcong">Đơn hàng - <span class="text-success">Đã giao</span></li>
                        <li class="list-group-item order-status" data-id_user="<?php echo $pro['id_user'] ?>" data-status="huydon">Đơn hàng - <span class="text-danger">Đã hủy</span></li>
                        <li class="list-group-item order-status" data-id_user="<?php echo $pro['id_user'] ?>" data-status="new">Đơn hàng - <span class="text-warning">Mới</span></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="orderDetailContent" class="mt-4">
                            <!-- Thông tin chi tiết đơn hàng sẽ được tải và hiển thị ở đây -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- Modal Structure -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi Tiết Đơn Hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nơi hiển thị chi tiết đơn hàng -->
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        // Sự kiện click vào trạng thái đơn hàng để xem chi tiết
        $(".order-status").click(function() {
            var status = $(this).data("status");
            var idUser = $(this).data("id_user");
            $.ajax({
                url: "fetch_order_details.php",
                type: "POST",
                data: {
                    status: status,
                    id_user: idUser
                },
                success: function(response) {
                    $("#orderDetailContent").html(response);
                    attachEventListeners();
                }
            });
        });

        function attachEventListeners() {
            // Sự kiện click cho nút "Xem Chi Tiết"
            $('.view-detail').off('click').on('click', function() {
                var orderId = $(this).data('id');
                $.ajax({
                    url: "detailOrder.php", // Thay đổi URL phù hợp với endpoint của bạn
                    type: "POST",
                    data: {
                        id: orderId
                    },
                    success: function(response) {

                        $("#orderDetailModal .modal-body").html(response);
                        $("#orderDetailModal").modal("show");
                    }
                });
            });

            // Sự kiện click cho nút "Hủy"
            $('.cancel-order').off('click').on('click', function() {
                var orderId = $(this).data('id');
                if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
                    $.ajax({
                        url: "cancel_order.php", // Điều chỉnh URL theo file xử lý hủy đơn hàng của bạn
                        type: "POST",
                        data: {
                            id: orderId
                        },
                        success: function(response) {
                            // Hiển thị thông báo hoặc cập nhật trạng thái đơn hàng
                            alert(response);
                            // Có thể reload trang để cập nhật thông tin đơn hàng mới
                            location.reload();
                        }
                    });
                }
            });
        }

        // Gọi hàm attachEventListeners lần đầu để kích hoạt sự kiện sau khi tải trang
        attachEventListeners();
    });
</script>





<?php
// Hàm này kiểm tra xem hình ảnh có tồn tại và là file hay không.
// Nếu không, trả về đường dẫn của hình ảnh mặc định.
function getImagePath($path)
{
    if (file_exists($path) && is_file($path)) {
        return $path;
    } else {
        return 'https://via.placeholder.com/150';
    }
}
?>