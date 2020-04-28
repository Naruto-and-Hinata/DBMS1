<div class="panel panel-default friends" style="border-radius:4px; ">
    <div class="panel-heading" style="border-radius:4px; ">
        <h3 class="panel-title">
            <?php
                if (isset($profile) || isset($members)) {
                    echo "My Friends";
                } else {
                    echo $userdata['first_name'] . "'s friends";
                }
            ?>
                
        </h3>
    </div>
    <div class="panel-body">
        <ul>
        <?php
            if (isset($profile)) {
                if (sizeof($friends) == 0) {
                    echo "<h4>Friends list is empty. You can add new <a  href='members.php'>friends</a></h4>";
                }
            } else {
                if (sizeof($friends) == 0) {
                    echo "<h4>Friends list is empty.</h4>";
                }
            }
            for ($i = 0; $i < sizeof($friends); $i++) {
                echo "<li>
                <a href='profile.php?id=" . $friends[$i]['id'] . "' class=\"post-avatar thumbnail\"><img style=\"border-radius:50%;\"
                src= " . $friends[$i]['image_path'] . " alt=\"\"><div class=\"text-center\">" . $friends[$i]['first_name'] . "</div></a></li>";
            }
        ?>
        </ul>
    </div>
</div>