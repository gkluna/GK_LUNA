<?php
function totalRevenue()
{
    $sql = "SELECT SUM(TongGia) AS TongDoanhThu FROM donhang;";
    return pdo_query_one($sql);
}
function revenue()
{
    $sql = "SELECT YEAR(NgayTao) AS Nam,MONTH(NgayTao) AS Thang, SUM(TongGia) AS TongDoanhThu FROM donhang 
        GROUP BY YEAR(NgayTao),MONTH(NgayTao)
        ORDER BY Nam, Thang";
    return pdo_query($sql);
}
function revenueWithAllDays($startDate, $endDate)
{

    $result = [];

    // Truy vấn cơ sở dữ liệu để lấy doanh thu mỗi ngày trong khoảng thời gian
    $sql = "SELECT DATE(NgayTao) as Ngay, SUM(TongGia) AS TongDoanhThu
            FROM donhang
            WHERE NgayTao BETWEEN '$startDate' AND '$endDate'
            GROUP BY DATE(NgayTao)
            ORDER BY DATE(NgayTao) ASC";
    $data = pdo_query($sql);

    // Tạo một DateTime object cho startDate và endDate
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end = $end->modify('+1 day'); // Thêm một ngày để đảm bảo endDate được bao gồm

    // Tạo một DatePeriod từ startDate đến endDate
    $interval = new DateInterval('P1D'); // Đặt khoảng cách là một ngày
    $daterange = new DatePeriod($start, $interval, $end);

    // Lặp qua mỗi ngày trong khoảng thời gian
    foreach ($daterange as $date) {
        $dateFormatted = $date->format("Y-m-d");
        // Kiểm tra xem ngày hiện tại có trong kết quả truy vấn không
        $found = false;
        foreach ($data as $row) {
            if ($row['Ngay'] == $dateFormatted) {
                // Nếu có, thêm vào mảng kết quả và đánh dấu là đã tìm thấy
                $result[] = ['Ngay' => $dateFormatted, 'TongDoanhThu' => $row['TongDoanhThu']];
                $found = true;
                break;
            }
        }
        if (!$found) {
            // Nếu không tìm thấy, thêm ngày với doanh thu là 0 vào mảng kết quả
            $result[] = ['Ngay' => $dateFormatted, 'TongDoanhThu' => 0];
        }
    }

    return $result;
}

function calculateTotalRevenue($startDate, $endDate) {
   
    $sql = "SELECT SUM(TongGia) AS total_revenue FROM donhang  WHERE NgayTao BETWEEN '$startDate' AND '$endDate'";
    $totalRevenue = pdo_query_one($sql);
    return $totalRevenue['total_revenue'] ?? 0;
 

}