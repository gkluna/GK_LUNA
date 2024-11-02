<div class="container mt-4">
    <div class="container margin_40">
        <div class="row justify-content-center">


            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng doanh thu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($totalRevenue['TongDoanhThu'], 0, '.', ','); ?> VNĐ</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <a href="index.php?act=orders">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalOrder ?></div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Người dùng</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalusers ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="index.php?act=bieudo" method="POST" class="form-inline justify-content-center">
                <div class="form-group mb-2">
                    <select name="timeframe" class="form-control" id="timeframeSelect">
                        <option value="">Mặc định</option>
                        <option value="this_week">Tuần này</option>
                        <option value="this_month">Tháng này</option>
                        <option value="this_quarter">Quý này</option>
                        <option value="this_year">Năm nay</option>
                        <option value="custom">Tùy chỉnh</option>
                    </select>
                </div>
                <!-- Các trường chọn ngày cho tùy chọn "Tùy chỉnh" -->
                <div class="form-group mb-2 custom-date-range" style="display: none;">
                    <input type="date" name="start_date" class="form-control ml-2">
                    <input type="date" name="end_date" class="form-control ml-2">
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Lọc</button>
            </form>

        </div>
    </div>
    <h5>Doanh thu: <?php echo number_format($total, 0, '.', ',') ?> VND</h5>
   
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu Đồ Doanh Thu</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <!-- Thẻ chứa biểu đồ (Google Charts hoặc biểu đồ khác) -->
                        <div id="chart_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ngày');
        data.addColumn('number', 'Tổng Doanh Thu');

        data.addRows([
            <?php
            foreach ($revenueData as $row) {
                $date = DateTime::createFromFormat('Y-m-d', $row['Ngay']);
                // Kiểm tra nếu là tháng 1 hoặc tháng 12 thì hiển thị cả năm
                if ($date->format('n') == 1 || $date->format('n') == 12) {
                    $formattedDate = $date->format('m-d Y'); // Định dạng mm-dd yyyy cho tháng 1 và 12
                } else {
                    $formattedDate = $date->format('m-d'); // Định dạng mm-dd cho các tháng khác
                }
                echo "['" . $formattedDate . "', " . $row['TongDoanhThu'] . "],";
            }
            ?>

        ]);

        var options = {
            title: 'Doanh thu hàng ngày',
            hAxis: {
                title: 'Ngày',
                titleTextStyle: {
                    color: '#333'
                },
                format: 'dd/MM', // Định dạng ngày tháng
                textStyle: {
                    slantedText: true, // Xoay nhãn để dễ đọc
                    slantedTextAngle: 45 // Góc xoay
                },
                showTextEvery: 1, // Kiểm soát số lượng nhãn được hiển thị, ví dụ: hiển thị mỗi nhãn
            },
            vAxis: {
                minValue: 0
            }
        };


        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById('timeframeSelect');
        var customDateRange = document.querySelector('.custom-date-range');

        select.addEventListener('change', function() {
            // Hiển thị các trường ngày khi người dùng chọn "Tùy chỉnh"
            if (this.value === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    });
</script>