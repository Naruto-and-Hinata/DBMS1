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
<script src="../functions/script.js"></script>

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
