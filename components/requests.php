<?php

$requests_users=[];
$requests = [];

$query = oci_parse($link, "select * from requests where user_id='" . $userdata['ID'] . "'");
oci_execute($query);
oci_fetch_all($query,$requests_users,null,null,OCI_FETCHSTATEMENT_BY_ROW);




    if (isset($profile)){
        echo "<div class=\"panel panel-default groups\">
            <div class=\"panel-heading\">
            <h3 class=\"panel-title\">Latest Requests</h3>
            </div>
            <div class=\"panel-body\">";

            if (sizeof($requests_users)>0){
                foreach ($requests_users as $user ){
                    echo "<div class=\"group-item\">
                    <img src='".$user['IMAGE']."' alt=\"\">
                    <h4><a href='profile.php?id=".$user['ID']."' class=\"\">".$user['FIRST_NAME']." ".$user['LAST_NAME']."</a></h4>
                    <form onsubmit='' ><button onclick=\"addFriend(".$user['ID'].")\" class='btn btn-success btn-sm'>Accept</button>
                    <button onclick=\"declineFriend(".$user['ID'].")\" class='btn btn-danger btn-sm'>Decline</button></form>
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