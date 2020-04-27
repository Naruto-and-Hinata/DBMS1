<?php
// Скрипт проверки

// Соединямся с БД
include "db.php";
echo $_COOKIE['hash'] . "<br>";

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $query = oci_parse($link, "SELECT * FROM users WHERE id = '" . intval($_COOKIE['id']) . "' ");
    oci_execute($query);
    $userdata = oci_fetch_assoc($query);
    print_r($userdata);
    echo $userdata['HASH'] . "   ";
    if (($userdata['HASH'] !== $_COOKIE['hash']) or ($userdata['ID'] !== $_COOKIE['id'])) {

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
