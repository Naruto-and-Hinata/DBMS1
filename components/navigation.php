
   
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
                <?php
                $path = explode("/", $_SERVER['PHP_SELF']);
//                print_r($path[2]);
                ?>
                <li  <?php if($path[2]=="main") echo "class='active'";?> > <a href="../main/index.php">Home</a></li>
                <li <?php if($path[2]=="members") echo "class='active'";?> > <a href="../members/members.php">Members</a></li>
                <!-- <li><a href="../photos/photos.html">Photos</a></li> -->
                <li <?php if($path[2]=="profile") echo "class='active'";?> ><a href="../profile/profile.php">Profile</a></li>
                <li><a style="color:orangered;" href="../login/logout.php">Log out</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>