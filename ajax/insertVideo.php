<?php
require_once __DIR__."/../php/daos/videoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";
require_once __DIR__."/../php/models/Media.class.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

$url = $_POST['path'];
if (!isset($url)) {
    header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "No URL entered.";
            exit();
}



$videoDAO = new videoDAO(new PDO(URL.DB, USER, PASS));




$media = new Media("Video", "", "", "", "", $url);
if ($videoDAO->create($media)) {
    echo "Video Added Successfully!";
}

else {
    echo "Video add failed!";
}


