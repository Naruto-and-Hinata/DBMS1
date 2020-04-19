<?php
$link = mysqli_connect("localhost", "root", "", "middb");
$friends = [];

$requests = [];
$requests_users=[];
$user = mysqli_query($link, "select * from users where hash='" . $_COOKIE['hash'] . "'");

$userdata = mysqli_fetch_assoc($user);
$query = mysqli_query($link, "select * from friends where user='" . $userdata['id'] . "' limit 15");
while ($row = mysqli_fetch_assoc($query)) {
    $images = mysqli_query($link, "select id,image_path,first_name from users where id='" . $row['friend'] . "'");
    array_push($friends, mysqli_fetch_assoc($images));
}
$query = mysqli_query($link, "select * from requests where user_to='" . $userdata['id'] . "'and  accepted=0 limit 5");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($requests, $row);
    $user = mysqli_query($link, "select id,image_path,first_name,last_name from users where id='" . $row['user'] . "'");
    array_push($requests_users, mysqli_fetch_assoc($user));

}