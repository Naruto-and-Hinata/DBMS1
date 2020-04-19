<!DOCTYPE html>
<?php ?>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="login.css">
    <title></title>
</head>
<body>
<div class="login">
    <div class="login-box">
        <div class="name">
            Registration
        </div>
        <?php
        $link = mysqli_connect("localhost", "root", "", "middb");

        $err = [];
        if (isset($_POST['submit'])) {
            $first_name=$_POST['first'];
            $last_name=$_POST['last'];
            $password=$_POST['password'];
            $phone=$_POST['phone'];
            $date_birth=$_POST['birth'];
            $gender=$_POST['gender'];
            $confirm=$_POST['confirm'];

            // проверям логин
            if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
                array_push($err,'First name must contain only latin letters and numbers!');
            }
            if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
                array_push($err,'Last name must contain only latin letters and numbers!');
            }
            if ($password!=$confirm) {
                array_push($err,'Passwords not equal!');
            }
            if (strlen($last_name) < 3 or strlen($last_name) > 50) {
                array_push($err,'Last name must be more than 3 symbols!');
            }
            if (strlen($first_name) < 3 or strlen($first_name) > 50) {
                array_push($err,'First name must be more than 3 symbols!');
            }
            if (strlen($password) < 8 or strlen($password) > 30) {
                array_push($err,'Password must be more than 8 symbols!');
            }

            // проверяем, не сущестует ли пользователя с таким именем
            $query = mysqli_query($link, "SELECT * FROM users WHERE phone_number='$phone'");
            if (mysqli_num_rows($query) > 0) {
                array_push($err,'User with this phone number exist!');
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
        <form class="form-login" action="" method="POST">
            <input type="text" name="first" value=""  required placeholder="First name">
            <input type="text" name="last" value=""  required placeholder="Last name">

            <input type="text" name="phone" value="" required placeholder="Phone number">
            <select name="gender">
                <option>Male</option>
                <option>Female</option>
            </select>
            <input type="date" name="birth" required value="" placeholder="Birth date">

            <input type="password" name="password" required value="" placeholder="Password">
            <input type="password" name="confirm" required value="" placeholder="Repeat">

            <input type="submit" name="submit" value="Register" style="background:#0078D7; color: white;">


        </form>
        <?php
        if(isset($err)){
            foreach ($err as $error){
                echo "<div class='err'>$error<br></div>";
            }
        }
        ?>
        Have account? <a href="login.php">Log In</a>
    </div>
</div>
</body>
</html>

