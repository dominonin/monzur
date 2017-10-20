<?php
require_once __DIR__."/../php/daos/photoDAO.class.php";
require_once __DIR__."/../php/models/Media.class.php";
require_once __DIR__."/../php/connection.properties.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

$selector = $_POST["content"];
$folder;
$upload_prefix = __DIR__ . "/../";
$full_path;
$file;
$dao;

if (is_uploaded_file($_FILES['file']['tmp_name'])) {

    switch ($selector) {
        case "photo":
            $folder = "images/";
            $dao = new photoDAO(new PDO(URL.DB, USER, PASS));
            break;
         default:
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "Selector not defined";
            exit();
            break;
    }

    $full_path = $upload_prefix . $folder;

    $file = $full_path . basename($_FILES['file']['name']);
    
    if (file_exists($file)) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-type: text/plain');
        echo "File already exists.";
        exit();
    }

    else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            echo "File uploaded succesfully\n";

            if ($dao->Create(new Media($selector, "", "", "", "", $folder . basename($_FILES['file']['name'])))) {
                echo "Successful insert into DB";
            }

            else {
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-type: text/plain');
                echo "Insert Failed!";
            }
        }
    }
}

else {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    echo "Error: File could not be uploaded.";
}