<?php
$link = mysqli_connect("localhost", "root", "", "middb");

$err = [];

if (isset($_POST['submit'])) {
    $first_name = $_POST['first'];
    $last_name = $_POST['last'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $date_birth = $_POST['birth'];
    $gender = $_POST['gender'];
    $confirm = $_POST['confirm'];

    // проверям логин
    if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        array_push($err, 'First name must contain only latin letters and numbers!');
    }
    if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        array_push($err, 'Last name must contain only latin letters and numbers!');
    }
    if ($password != $confirm) {
        array_push($err, 'Passwords not equal!');
    }
    if (strlen($last_name) < 3 or strlen($last_name) > 50) {
        array_push($err, 'Last name must be more than 3 symbols!');
    }
    if (strlen($first_name) < 3 or strlen($first_name) > 50) {
        array_push($err, 'First name must be more than 3 symbols!');
    }
    if (strlen($password) < 8 or strlen($password) > 30) {
        array_push($err, 'Password must be more than 8 symbols!');
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT * FROM users WHERE phone_number='$phone'");
    if (mysqli_num_rows($query) > 0) {
        array_push($err, 'User with this phone number exist!');
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if (count($err) == 0) {


        $date = date('Y-m-d');
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link, "INSERT INTO users SET first_name='" . $first_name . "', password='" . $password . "',phone_number='$phone',date_registration='$date', date_birth='$date_birth',gender='$gender',last_name='$last_name' ");
        header("Location: login.php");

    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap core CSS -->
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
                    <h4 class="card-title mt-2 card-header-sign">Sign up</h4>
                    <a href="login.php" class="float-right btn btn-outline-primary mt-1">Log in</a>

                </header>
                <article class="card-body">
                    <form method="post">
                        <div class="form-row">
                            <div class="col form-group">
                                <label>First name </label>
                                <input type="text" name="first" required class="form-control" placeholder="">
                            </div> <!-- form-group end.// -->
                            <div class="col form-group">
                                <label>Last name</label>
                                <input name="last" type="text" required class="form-control" placeholder=" ">
                            </div> <!-- form-group end.// -->
                        </div> <!-- form-row end.// -->

                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input name="city" type="text" required class="form-control">
                            </div>
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
                                <label>Repeat password</label>
                                <input name="confirm" required class="form-control" type="password">
                            </div> <!-- form-group end.// -->
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" required class="form-control">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div> <!-- form-group end.// -->
                            <div class="form-group">
                                <label>Born date</label>
                                <input class="form-control" required name="birth" type="date">
                            </div> <!-- form-group end.// -->

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-group">

                                        <input name="submit" type="submit" value="Register" class="btn btn-primary btn-block">
                                    </div> <!-- form-group// -->
                                    <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you
                                        accept our <br> Terms of use and Privacy Policy.</small>
                    </form>
                </article> <!-- card-body end .// -->
                <?php
                if (isset($err)) {
                    foreach ($err as $error) {
                        echo "<div class='err'>$error<br></div>";
                    }
                }
                ?>

                <div class="border-top card-body text-center">Have an account? <a href="login.php">Log In</a></div>
            </div> <!-- card.// -->
        </div> <!-- col.//-->

    </div> <!-- row.//-->


</div>
<!--container end.//-->

<br><br>

<article class="bg-secondary mb-3">

    <br><br>
</article>

</body>
</html>