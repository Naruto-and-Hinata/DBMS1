<?php
$users = [];
$friends_id=[];
$friends=[];
$link = mysqli_connect("localhost", "root", "", "middb");
if(isset($_POST['submit'])){
    $query = mysqli_query($link, "select * from users where first_name like '%".$_POST['search']."%' or last_name like '".$_POST['search']."' limit 15");
}
else{
    $query = mysqli_query($link, "select * from users limit 15");
}
while ($row = mysqli_fetch_assoc($query)) {
    if ($row['id']!=$_COOKIE['id']){
        array_push($users, $row);
    }
}

$query=mysqli_query($link,"select * from friends where user='".$_COOKIE['id']."'");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($friends_id, $row['friend']);
    $images = mysqli_query($link, "select id,image_path,first_name from users where id='" . $row['friend'] . "'");
    array_push($friends, mysqli_fetch_assoc($images));
}
$query=mysqli_query($link,"select * from requests where user='".$_COOKIE['id']."'");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($friends_id, $row['user_to']);

}

$user = mysqli_query($link, "select * from users where hash='" . $_COOKIE['hash'] . "'");
$userdata = mysqli_fetch_assoc($user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dobble Social Network: Members Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="container">
        <img src="../img/logo.jpg" class="logo" alt="">

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
                <li ><a href="../main/index.php">Home</a></li>
                <li class="active"><a href="members.php">Members</a></li>
                <!-- <li><a href="../photos/photos.html">Photos</a></li> -->
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
                <form method="post" style="display: flex;">
                    <input name="search" class="form-control" type="search" placeholder="Search.." >
                    <input name="submit" class="btn btn-success btn-block" value="Search!" type="submit" style="width: 100px;">
                </form>
                <br>
                <div>Assignment</div>
                <div class="members">
                    <h1 class="page-header">Members</h1>
                    <?php
                    if (sizeof($users) > 0) {
                        foreach ($users as $user) {
                            if(in_array($user['id'],$friends_id)){
                                $class="btn btn-success btn-block disabled";
                            }
                            else
                                $class="btn btn-success btn-block";
                            echo "<div class=\"row member-row\">
                        <div class=\"col-md-3\">
                            <img src=".$user['image_path']." class=\"img-thumbnail\" alt=\"\">
                            <div class=\"text-center\">
                               ".$user['first_name']." ".$user['last_name']."
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                        <form onsubmit='event.preventDefault()'><p><button onclick='addFriend(".$user['id'].")'  class='".$class."'><i class=\"fa fa-users\"></i> Add Friend</button>
                            </p></form>

                        </div>

                        <div class=\"col-md-3\">
                            <p><a href='../profile/profile.php?id=".$user['id']."' class=\"btn btn-primary btn-block\"><i class=\"fa fa-edit\"></i> View Profile</a>
                            </p>
                        </div>
                    </div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $profile = 1;
                    include '../components/friends.php';
                ?>

                <?php
                    $profile = 1;
                    include '../components/requests.php';
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
<script src="../https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/axios.js"></script>
<script>
    function addFriend(id) {
        axios.post('../actions/actions.php',{friend:id}).then(res=>{
            console.log(res.data)
        })
    }
</script>
</body>
</html>
