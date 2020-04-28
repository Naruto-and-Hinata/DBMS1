<?php
$error = [];

$target_dir = "../asserts/images/users/";
$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $error[] = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists

// Check file size
if ($_FILES["userfile"]["size"] > 500000) {
    $error[] = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    $error[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    foreach ($error as $err) {
        echo $err;
    }
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
        include 'db.php';

        if (isset($_COOKIE['id'])) {
            if (isset($_POST['add_photo'])){
                $date=date('d-m-Y h:i:s');
                $query = oci_parse($link, "insert into USERS_photos(id,user_id,created_date,photo) values (USER_ID.nextval,'".$_COOKIE['id']."',to_date('$date','dd-mm-yy hh24:mi:ss'),'$target_file')");
                oci_execute($query);
            }else{
                $query = oci_parse($link, "UPDATE users SET image='$target_file' WHERE id = '" . intval($_COOKIE['id']) . "'");
                oci_execute($query);
            }
        }

    }
    header('Location: ../profile/profile.php');
}



