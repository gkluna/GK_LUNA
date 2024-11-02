<?php
session_start();
include "../model/pdo.php";
include "../model/users.php"; // Đảm bảo đường dẫn đến file users.php đúng

$error = ""; // Khởi tạo biến lỗi

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $user = checkLogin($email, $pass);
    if($user) {
        $_SESSION['admin'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['userName'] = $user['userName'];
        header("Location: index.php"); // Chuyển hướng đến trang quản trị
        exit();
    } else {
        $error = "Thông tin đăng nhập không chính xác!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="form-box">
        <form action="login.php" method="POST">
         <h2>Login</h2>
            <div class="inputbox"> 
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="inputbox">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pass" placeholder="Password" required>
            </div>
            <!-- Hiển thị thông báo lỗi ở đây -->
            <?php if(!empty($error)): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>
           
            <a href="#" class="forget-password">Forget Password?</a>

            
            <button type="submit" name="login">Log in</button>
        </form>
    </div>
</body>
</html>
