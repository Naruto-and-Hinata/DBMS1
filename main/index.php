<?php


$link = mysqli_connect("localhost", "root", "", "middb");
$friends = [];
$profile=1;
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
if(!isset($_COOKIE['id'])){
    header('Location: ../login/login.php');
}
$wall=[];
$users=[];
$query=mysqli_query($link,"select * from wall order by date desc ");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($wall, $row);
    $creator=mysqli_query($link,"select * from users where id='".$row['user']."' ");
    array_push($users,mysqli_fetch_assoc($creator));
}

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
        <img src="../img/logo.jpg" class="logo" alt="">
    </div>
</header>

<?php 
	include '../components/navigation.php';
?> 

<section>
    <div class="container">
    	
        <div class="row">
            <div class="col-md-8">
            	<?php 
                    include '../components/friends.php';
		?> 
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
                            foreach ($users as $user){

                                if ($user['id']==$post['user']){
                                    $post_user=$user;
                                }
                            }
                            if($_COOKIE['id']==$post['user']){
                                $delete="<button onclick='deletePost(".$post['id'].")' class='btn btn-link btn-danger'>Delete</button>";
                            }
                            else{
                                $delete='';
                            }
                            echo "<div class=\"panel panel-default post\">";
                            echo "<div class=\"panel-body\">";
                            echo "<div class=\"col-sm-2\">
                                        <a href='../profile/profile.php?id=" . $post_user['id'] . "' class=\"post-avatar thumbnail\"><img style=\"border-radius:50%;\" 
                                            src= " . $post_user['image_path']  . " alt=\"\"><div class=\"text-center\">" . $post_user['first_name'] . "</div></a></div>";
                        echo "<div class=\"col-sm-10\">";
                            echo "<div class=\"likes text-end\">" . $post['date'] . "</div>";

                            echo "<div class=\"bubble \" style='width: 90%'>";
                            echo "<div class=\"pointer\">";
                            echo "<p>" . $post['text'] . "</p>";
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
                <?php
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/axios.js"></script>

<script>
    function addPost() {
        if(document.getElementById('text_wall').value.length > 0){
            axios.post('../actions/actions.php', {
            text: document.getElementById('text_wall').value,
            type:'global'
        }).then(res => {
            console.log(res.data)
        })
    
        }
        

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

    <style>

        #text_wall{
            min-height: 100px;
            min-width: 20%;
            max-width: 100%;
        }

</body>
</html>
