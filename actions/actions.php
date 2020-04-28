<?php
$data=json_decode(file_get_contents("php://input"),true);
var_dump($data);
include 'db.php';
$user = $_COOKIE['id'];
//if(isset($_POST['delete'])){
//    $id=$_POST['delete'];
//    $sql="DELETE FROM `profile_wall` WHERE `id` = $id";
//    $query=oci_parse($link,$sql);
//    echo $query;
//}

if (isset($data['text']) && !isset($data['type'])) {
    $text = $data['text'];
    $date = date('d-m-Y h:i:s');
    echo $date;
    $sql = "INSERT INTO profile_wall (id, USER_ID, text, CREATED_DATE) VALUES (USER_ID.nextval, '$user', '$text', to_date('$date','dd-mm-yy hh24:mi:ss'))";
    $query = oci_parse($link, $sql);
    oci_execute($query);
}

if (isset($data['type']) && $data['type']=='global' && isset($data['text'])) {
    $text = $data['text'];
    $date = date('d-m-Y h:i:s');
    echo 1;
    $sql = "INSERT INTO wall(id, user_id, text, created_date) VALUES (USER_ID.nextval, '$user', '$text', to_date('$date','dd-mm-yy hh24:mi:ss'))";
    $query = oci_parse($link, $sql);
    oci_execute($query);
}
if (isset($data['type']) && $data['type']=='global' && isset($data['delete_post'])) {
    $post = $data['delete_post'];
    echo 1;
    $sql = "delete from wall where id='".$post."'";
    $query = oci_parse($link, $sql);
    oci_execute($query);
}
if (isset($data['friend'])){
    $friend=$data['friend'];
    $date = date('Y-m-d');
    $sql = "INSERT INTO FRIENDS (id, FRIEND, user_id, REQUEST_DATE) VALUES (USER_ID.nextval, '$user', '$friend', to_date('$date','YYYY-MM-DD'))";
    $query = oci_parse($link, $sql);
    oci_execute($query);
    echo 1;

}
if (isset($data['friend_id'])){
    $friend=$data['friend_id'];
    echo $friend;
    $date = date('Y-m-d ');
    echo $date;
    $sql = "update friends  set DATE_ACCEPTED=to_date('$date','YYYY-MM-DD') , ACCEPTED=1  where user_id=$user and fRIEND=$friend";
    $query = oci_parse($link, $sql);
    oci_execute($query);
    $sql = "INSERT INTO friends (id, user_id, friend,DATE_ACCEPTED,ACCEPTED) VALUES (USER_ID.nextval, '$friend', '$user',to_date('$date','YYYY-MM-DD'),1)";
    $query = oci_parse($link, $sql);
    oci_execute($query);


    echo 1;

}
if (isset($data['decline'])){
    $friend=$data['decline'];
    echo $friend;
    $date = date('Y/m/d/ H:i:s');
    $sql="update friends set accepted=-1 where user_id in('".$friend."','$user') ";
    $query = oci_parse($link, $sql);
    oci_execute($query);
    echo 1;

}
if (isset($data['friend_id'])&&isset($data['delete'])){
    $friend=$data['friend_id'];
    $query=oci_parse($link,"delete from FRIENDS where USER_ID in('$user','$friend') and FRIEND in ('$user','$friend')");
    oci_execute($query);
    echo 'deleted';
}