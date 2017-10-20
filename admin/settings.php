<?php
require_once __DIR__."/../php/config.php";

$mediatype = $_POST['media'];
$dest_dir = __DIR__ . "/site_content/";
$type;
$file;
$heading;
$config_prefix = "admin/site_content/home";

if (isset($_FILES["file"])) {
    $file = $_FILES["file"]["name"];
    $type = pathinfo($file)["extension"];
}

else if(isset($_POST["heading"])) {
    $heading = $_POST["heading"];
}

else {
    header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
    echo "No file";
    exit();
}

if ($mediatype === "bg") {
    if ($type != "jpg" && $type != "png" && $type != "jpeg" && $type != "gif") {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "Only images are allowed for backgrounds (jpg, png, jpeg, gif)";
        exit();
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $dest_dir . "homeImage." . $type)) {
        echo "File uploaded succesfully";

        $obj->{"home-img"} = $config_prefix . "Image." . $type;

        if (file_put_contents(__DIR__."/config.json", json_encode($obj, JSON_UNESCAPED_SLASHES))) {
            echo "\n Configuration updated succesfully";
        }
        else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "\n Configuration update failed!";
        }
    }

}

else if ($mediatype == "vbg") {
    if ($type != "mp4") {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "Only mp4s are allowed for video background";
        exit();
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $dest_dir . "homeVideo." . $type)) {
        echo "File uploaded succesfully";
        }

        else {
            echo "File failed to be uploaded";
        }
    }

    else if ($mediatype == "song") {
        if ($type != "mp3") {
            header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "Only mp3s are allowed for song";
        exit();
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $dest_dir . "song." . $type)) {
        echo "File uploaded succesfully";
        }

        else {
            echo "File failed to be uploaded";
        }
    }

    else if ($mediatype == "top") {
        $obj->{"top-heading"} = $heading;

        if (file_put_contents(__DIR__."/config.json", json_encode($obj, JSON_UNESCAPED_SLASHES))) {
            echo "\n Configuration updated succesfully";
        }
        else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "\n Configuration update failed!";
        }
    }

    else if ($mediatype == "bottom") {
        $obj->{"bottom-heading"} = $heading;

        if (file_put_contents(__DIR__."/config.json", json_encode($obj, JSON_UNESCAPED_SLASHES))) {
            echo "\n Configuration updated succesfully";
        }
        else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "\n Configuration update failed!";
        }
    }

    else if ($mediatype == "lower-right") {
        $obj->{"lower-right-heading"} = $heading;

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
    echo "No filetype specified!";
    exit();
}
?>