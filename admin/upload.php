<?php
require_once __DIR__."/../php/config.php";

$target_dir = "/site_content/";
$target_file = __DIR__. $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$new_target = __DIR__. $target_dir . "aboutImage." . $imageFileType;
$config_path = "admin/" . basename($target_dir) . "/" . "aboutImage." .$imageFileType;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "File is not an image.\n";
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    echo "Sorry, your file was not uploaded.\n";
}
// if everything is ok, try to upload file
else{

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $new_target)) {
        echo "About page image uploaded successfully";

        $obj->{"about-img"} = $config_path;

        if (file_put_contents(__DIR__."/config.json", json_encode($obj, JSON_UNESCAPED_SLASHES))) {
            echo "\n Configuration updated succesfully";
        }
        else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "\n Configuration update failed!";
        }
        }

     else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "Sorry, there was an error uploading your file.";
    }
}
?>