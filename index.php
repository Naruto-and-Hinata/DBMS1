<?php
include 'actions/db.php';
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])){
    $query=oci_parse($link,"select hash from users where id='".$_COOKIE['id']."'");
    oci_execute($query);
    $user=oci_fetch_assoc($query);
    if ($user['HASH']==$_COOKIE['hash'])
        header('Location: main/index.php');
    else
        header('Location: login/login.php');
}
else
    header('Location: login/login.php');

