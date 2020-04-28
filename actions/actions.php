<?php
$data=json_decode(file_get_contents("php://input"),true);
var_dump($data);
include 'db.php';
$user = $_COOKIE['id'];
if(isset($_POST['delete'])){
    $id=$_POST['delete'];
    $sql="DELETE FROM `profile_wall` WHERE `id` = $id";
    $query=oci_parse($link,$sql);
    echo $query;
}

if (isset($data['text']) && !isset($data['type'])) {
    $text = $data['text'];
    $date = date('Y-m-d H:i:s');
    echo $date;
    $sql = "INSERT INTO `profile_wall` (`id`, `user`, `text`, `date`) VALUES (NULL, $user, '$text', '$date')";
    $query = oci_parse($link, $sql);
}

if (isset($data['type']) && $data['type']=='global' && isset($data['text'])) {
    $text = $data['text'];
    $date = date('Y-m-d H:i:s');
    echo 1;
    $sql = "INSERT INTO `wall` (`id`, `user`, `text`, `date`) VALUES (NULL, $user, '$text', '$date')";
    $query = oci_parse($link, $sql);
}
if (isset($data['type']) && $data['type']=='global' && isset($data['delete_post'])) {
    $post = $data['delete_post'];
    echo 1;
    $sql = "delete from `wall` where id='".$post."'";
    $query = oci_parse($link, $sql);
}
if (isset($data['friend'])){
    $friend=$data['friend'];
    $date = date('Y/m/d/ H:i:s');
    $sql = "INSERT INTO `requests` (`id`, `user`, `user_to`, `date`) VALUES (NULL, $user, '$friend', '$date')";
    $query = oci_parse($link, $sql);
    echo 1;

}
if (isset($data['friend_id'])){
    $friend=$data['friend_id'];
    echo $friend;
    $date = date('Y/m/d/ H:i:s');
    $sql = "INSERT INTO `friends` (`id`, `user`, `friend`) VALUES (NULL, $user, '$friend')";
    $query = oci_parse($link, $sql);
    $sql = "INSERT INTO `friends` (`id`, `user`, `friend`) VALUES (NULL, $friend, '$user')";
    $query = oci_parse($link, $sql);
    $sql="update friends set accepted=1 where user_id='".$friend."'";
    $query = oci_parse($link, $sql);
    oci_execute($query);

    echo 1;

}
if (isset($data['decline'])){
    $friend=$data['decline'];
    echo $friend;
    $date = date('Y/m/d/ H:i:s');
    $sql="update friends set accepted=-1 where user_id='".$friend."'";
    $query = oci_parse($link, $sql);
    oci_execute($query);
    echo 1;

}