<?php
// Страница авторизации
// Функция для генерации случайной строки
function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}

$err=[];
// Соединямся с БД
$link = mysqli_connect("localhost", "root", "", "middb");

if (isset($_POST['submit'])) {
    $query = mysqli_query($link, "SELECT id, password FROM users WHERE phone_number='" . mysqli_real_escape_string($link, $_POST['phone']) . "' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    $hash = md5(generateCode(10));
    // Сравниваем пароли
    if ($data['password'] === md5(md5($_POST['password']))) {
        // Генерируем случайное число и шифруем его
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET hash='" . $hash . "' WHERE id='" . $data['id'] . "'");

        // Ставим куки
        setcookie("id", $data['id'], time() + 3600 * 24 * 30 * 12, "/");
        setcookie("hash", $hash, time() + 3600 * 24 * 30 * 12,'/');
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: ../actions/check.php");
    } else {
        array_push($err,"Invalid username or password!");
    }
}
if(isset($_REQUEST['err'])){
    $error=$_REQUEST['err'];
    if ($error=='not_admin'){
        array_push($err,'You should log in with admin profile!');
    }
}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="login.css">
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/reg1.css" rel="stylesheet">
    <link href="login.css" rel="stylesheet">

    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/ekko-lightbox.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="cont">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title mt-2 card-header-sign">Log in</h4>
                    <a href="registration.php" class="float-right btn btn-outline-primary mt-1">Sign up</a>

                </header>
                <article class="card-body">
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone number</label>
                                <input name="phone" type="text" required class="form-control">
                            </div>
                        </div> <!-- form-row.// -->
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" required class="form-control" type="password">
                        </div> <!-- form-group end.// -->


                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-group">

                                    <input name="submit" type="submit" value="Login" class="btn btn-primary btn-block">
                                </div> <!-- form-group// -->

                    </form>
                </article> <!-- card-body end .// -->
                <?php
                if (isset($err)) {
                    foreach ($err as $error) {
                        echo "<div class='err'>$error<br></div>";
                    }
                }
                ?>

                <div class="border-top card-body text-center">Need account? <a href="registration.php">Register!</a></div>
            </div> <!-- card.// -->
        </div> <!-- col.//-->

    </div> <!-- row.//-->


</div>
</body>
</html>
