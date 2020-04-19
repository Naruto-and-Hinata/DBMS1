<?php
// Скрипт проверки

// Соединямся с БД
$link = mysqli_connect("localhost", "root", "", "middb");
echo $_COOKIE['hash'] . "<br>";

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $query = mysqli_query($link, "SELECT * FROM users WHERE id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    echo $userdata['hash'] . "   ";
    if (($userdata['hash'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])) {

        print "Error";
    } else {
        setcookie("id", $_COOKIE['id'], time() + 60 * 60 * 24 * 30, "/");
        setcookie("hash", $_COOKIE['hash'], time() + 3600 * 24 * 30 * 12, "/");
        header("Location: ../main/index.php");
    }
} else {
    print "Включите куки";
}
?>
