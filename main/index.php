<?php
include '../actions/db.php';
$friends = [];
$profile=1;
$requests = [];
$requests_users=[];
$user = oci_parse($link, "select * from users where hash='" . $_COOKIE['hash'] . "'");
oci_execute($user);
$userdata = oci_fetch_assoc($user);

$query = oci_parse($link, "select * from friends_info where user_id='" . $userdata['ID'] . "' ");
oci_execute($query);
oci_fetch_all($query,$friends,null,null,OCI_FETCHSTATEMENT_BY_ROW);


$query = oci_parse($link, "select * from requests where user_id='" . $userdata['ID'] . "'");
oci_execute($query);
oci_fetch_all($query,$requests_users,null,null,OCI_FETCHSTATEMENT_BY_ROW);


if(!isset($_COOKIE['id'])){
    header('Location: ../login/login.php');
}
$wall=[];
$users=[];
$query=oci_parse($link,"select * from wall_posts ");
oci_execute($query);
oci_fetch_all($query,$wall,null,null,OCI_FETCHSTATEMENT_BY_ROW)


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dobble Social Network</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="container">
        <img src="../img/logo.png" class="logo" alt="">
    </div>
</header>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="../members/members.php">Members</a></li>
                <li><a href="../photos/photos.html">Photos</a></li>
                <li><a href="../profile/profile.php">Profile</a></li>
                <li><a style="color:orangered;" href="../login/logout.php">Log out</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Wall</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (isset($profile)) {
                            echo "<form onsubmit=\"\">
                                        <div class=\"form-group\">
                                            <textarea class=\"form-control\" id=\"text_wall\" placeholder=\"Write on the wall\"></textarea>
                                        </div>
                                        <button type=\"submit\"  onclick=\"addPost()\" class=\"btn btn-default\">Submit</button>
                                        <div class=\"pull-right\">

                                        </div>
                                    </form>";
                        }
                        ?>
                    </div>
                </div>

                    <?php

                    if (sizeof($wall) > 0) {
                        foreach ($wall as $post) {
//                            if ($user['ID']==$post['USER_ID']){
//                                $post_user=$user;
//                            }

                            if($_COOKIE['id']==$post['USER_ID']){
                                $delete="<button onclick='deletePost(".$post['ID'].")' class='btn btn-link btn-danger'>Delete</button>";
                            }
                            else{
                                $delete='';
                            }
                            echo "<div class=\"panel panel-default post\">";
                            echo "<div class=\"panel-body\">";
                            echo "<div class=\"col-sm-2\">
                                        <a href='../profile/profile.php?id=" . $post['USER_ID'] . "' class=\"post-avatar thumbnail\"><img 
                                            src= " . $post['IMAGE']  . " alt=\"\"><div class=\"text-center\">" . $post['FIRST_NAME'] . "</div></a></div>";
                        echo "<div class=\"col-sm-10\">";
                            echo "<div class=\"likes text-end\">" . $post['TIME'] . "</div>";

                            echo "<div class=\"bubble \" style='width: 90%'>";
                            echo "<div class=\"pointer\">";
                            echo "<p>" . $post['TEXT'] . "</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class=\"clearfix\"></div>";
                            echo "</div>".$delete;
                            echo "</div>
                    </div>";
                        }

                    }
                    ?>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default friends">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Friends</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php
                            if (isset($profile)) {
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
                                        <a href='profile.php?id=" . $friends[$i]['ID'] . "' class=\"post-avatar thumbnail\"><img
                                            src= " . $friends[$i]['IMAGE'] . " alt=\"\"><div class=\"text-center\">" . $friends[$i]['FIRST_NAME'] . "</div></a></li>";
                            }
                            ?>
                        </ul>
                        <div class="clearfix"></div>

                    </div>
                </div>
                <?php
                if (isset($profile)) {
                    echo "<div class=\"panel panel-default groups\">
                    <div class=\"panel-heading\">
                        <h3 class=\"panel-title\">Latest Requests</h3>
                    </div>
                    <div class=\"panel-body\">";

                    if (sizeof($requests_users) > 0) {
                        foreach ($requests_users as $user) {
                            echo "<div class=\"group-item\">
                            <img src='" . $user['IMAGE'] . "' alt=\"\">
                            <h4><a href='profile.php?id=" . $user['ID'] . "' class=\"\">" . $user['FIRST_NAME'] . " " . $user['LAST_NAME'] . "</a></h4>
                            <form ><button onclick=\"addFriend(" . $user['ID'] . ")\" class='btn btn-success btn-sm'>Accept</button>
                            <button onclick=\"declineFriend(" . $user['ID'] . ")\" class='btn btn-danger btn-sm'>Decline</button></form>

                        </div>
                        <div class=\"clearfix\"></div>";
                        }
                    } else {
                        echo "<h4>Request list empty.</h4>";
                    }

                    echo "</div></div>";
                }


                ?>

            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>Dobble Copyright &copy, 2020</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/axios.js"></script>

<script>
    function addPost() {
        axios.post('../actions/actions.php', {
            text: document.getElementById('text_wall').value,
            type:'global'
        }).then(res => {
            console.log(res.data)
        })


    }
    function deletePost(id) {
        axios.post('../actions/actions.php', {
            delete_post: id,
            type:'global'
        }).then(res => {
            location.reload()
            console.log(res.data)
        })
    }
</script>
</body>
</html>
