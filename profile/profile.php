<?php


include "../actions/db.php";
$friends = [];

$requests = [];


$posts = [];
$url = parse_url($_SERVER['REQUEST_URI']);
if (isset($url['query'])) {
    parse_str($url['query'], $params);

}
if (isset($params['id'])&& $params['id']!=$_COOKIE['id'] ) {
    $user = oci_parse($link, "select * from users where id='" . $params['id'] . "'");

} else {
    $user = oci_parse($link, "select * from users where hash='" . $_COOKIE['hash'] . "'");
    $profile = 1;
}
oci_execute($user);
$userdata = oci_fetch_assoc($user);


    array_push($posts, $row);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dobble Social Network: Profile Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/font-awesome.css" rel="stylesheet">
    <style>

    	#text_wall{
    		min-height: 100px;
    		min-width: 20%;
    		max-width: 100%;
    	}

        .upload-btn-wrapper {
            margin: 7vw;
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .uploaded {
            left: 0;
            width: 90%;
            top: 100%;
            opacity: 0.8;
            position: absolute;
            margin: 0;

        }

        .bttn {
            width: 80%;
            border: 1px solid #04519b;
            color: darkblue;
            font-family: 'Solway', sans-serif;
            background-color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 1vw;
            font-weight: bold;
            opacity: 0.9;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 4vw;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;

        }
    </style>
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
                <li><a href="../main/index.php">Home</a></li>
                <li><a href="../members/members.php">Members</a></li>
                <!-- <li><a href="../photos/photos.html">Photos</a></li> -->
                <li class="active"><a href="profile.php">Profile</a></li>
                <li><a style="color:orangered;" href="../login/logout.php">Log out</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="profile">
                    <h1 class="page-header"> <?php echo $userdata['FIRST_NAME'] . " " . $userdata['LAST_NAME'] ?></h1>
                    <div class="row">
                        <div class="col-md-4">
                            <img <?php
                            echo "src=" . $userdata['IMAGE'];
                            ?> class="img-thumbnail" alt="">


                        </div>
                        <div class="col-md-8" style="border: 3px double #999999; background-color:#FDFDFD;	 ">
                            <ul>
                                <li>
                                    <strong>Name:</strong> <?php echo $userdata['FIRST_NAME'] . " " . $userdata['LAST_NAME'] ?>
                                </li>
                                <li><strong>Phone:</strong> <?php echo $userdata['PHONE_NUMBER'] ?></li>
                                <li><strong>Gender:</strong> <?php echo $userdata['GENDER'] ?></li>
                                <li><strong>DOB:</strong> <?php echo $userdata['DATE_BIRTH'] ?></li>
                                <li><strong>City:</strong> <?php echo $userdata['CITY'] ?></li>

                            </ul>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Profile Wall</h3>
                                </div>

                                <div class="panel-body">
                                    <?php
                                    if (isset($profile)) {
                                        echo "<form onsubmit=\"\">
                                        <div class=\"form-group\">
                                            <textarea class=\"form-control\" id=\"text_wall\" placeholder=\"Write on the wall\" ></textarea>
                                        </div>
                                        <button type=\"submit\"  onclick=\"addPost()\" class=\"btn btn-default\">Submit</button>
                                        <div class=\"pull-right\">

                                        </div>
                                    </form>";
                                    }
                                    ?>
                                </div>
                                <div class="row col-12">
                                    <?php
                                    if (sizeof($posts) > 0) {
                                        echo "<div class=\"col-sm-2\">
                                        <a href='profile.php?id=" . $userdata['ID'] . "' class=\"post-avatar thumbnail\"><img 
                                            src= " . $userdata['IMAGE'] . " alt=\"\"><div class=\"text-center\">" . $userdata['FIRST_NAME'] . "</div></a></div>";
                                    }
                                    ?>

                                    <div class="col-sm-10">
                                        <?php
                                        for ($i = 0; $i < sizeof($posts); $i++) {
                                            echo "<div class=\"likes text-end\">" . $posts[$i]['CREATE_DATE'] . "</div>";

                                            echo "<div class=\"bubble w-100\">";
                                            echo "<div class=\"pointer w-100\">";
                                            echo "<p>" . $posts[$i]['TEXT'] . "</p>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "<div class=\"clearfix\"></div>";
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <?php
                    include "../components/friends.php";          
                ?>


                <?php
                    include "../components/requests.php";          
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
<script src="../js/axios.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../functions/script.js"></script>
<script>
    function addPost() {
        axios.post('../actions/actions.php', {
            text: document.getElementById('text_wall').value,
        }).then(res => {
            console.log(res.data)
        })
    }
    
    
</script>
</body>
</html>

