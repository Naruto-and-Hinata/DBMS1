<?php
$friends=[];
?>

<div class="panel panel-default friends" style="border-radius:4px; ">
    <div class="panel-heading" style="border-radius:4px; ">
        <h3 class="panel-title">
            <?php
            $query = oci_parse($link, "select * from friends_info where user_id='" . $userdata['ID'] . "' and accepted=1 ");
            oci_execute($query);
            oci_fetch_all($query,$friends,null,null,OCI_FETCHSTATEMENT_BY_ROW);
                if ($profile) {
                    echo "My Friends";
                } else {
                    echo $userdata['FIRST_NAME'] . "'s friends";
                }
            ?>
                
        </h3>
    </div>
    <div class="panel-body">
        <ul>
        <?php
            if ($profile) {
                if (sizeof($friends) == 0) {
                    echo "<h4>Friends list is empty. You can add new <a  href='../members/members.php'>friends</a></h4>";
                }
            } else {
                if (sizeof($friends) == 0) {
                    echo "<h4>Friends list is empty.</h4>";
                }
            }
            for ($i = 0; $i < sizeof($friends); $i++) {
                echo "<li>
                <a href='../profile/profile.php?id=" . $friends[$i]['ID'] . "' class=\"post-avatar thumbnail\"><img 
                src= " . $friends[$i]['IMAGE'] . " alt=\"\"><div class=\"text-center\">" . $friends[$i]['FIRST_NAME'] . "</div></a></li>";
            }
        ?>
        </ul>
    </div>
</div>