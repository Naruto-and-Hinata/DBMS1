<?php

$requests_users=[];
$requests = [];

$query = mysqli_query($link, "select * from requests where user_to='" . $userdata['id'] . "'and  accepted=0 limit 5");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($requests, $row);
    $user = mysqli_query($link, "select id,image_path,first_name,last_name from users where id='" . $row['user'] . "'");
    array_push($requests_users, mysqli_fetch_assoc($user));

}




    if (isset($profile)){
        echo "<div class=\"panel panel-default groups\">
            <div class=\"panel-heading\">
            <h3 class=\"panel-title\">Latest Requests</h3>
            </div>
            <div class=\"panel-body\">";

            if (sizeof($requests_users)>0){
                foreach ($requests_users as $user ){
                    echo "<div class=\"group-item\">
                    <img style=\"border-radius:50%;\" src='".$user['image_path']."' alt=\"\">
                    <h4><a href='profile.php?id=".$user['id']."' class=\"\">".$user['first_name']." ".$user['last_name']."</a></h4>
                    <form ><button onclick=\"addFriend(".$user['id'].")\" class='btn btn-success btn-sm'>Accept</button>
                    <button onclick=\"declineFriend(".$user['id'].")\" class='btn btn-danger btn-sm'>Decline</button></form>
                    </div>
                    <div class=\"clearfix\"></div>";
                }
            }
            else{
                echo "<h4>Request list empty.</h4>";
            }
            echo "</div></div>";
        }
?>