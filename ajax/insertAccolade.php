<?php
require_once __DIR__."/../php/daos/accoladeDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";
require_once __DIR__."/../php/models/Media.class.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }


if (!isset($_POST['content'])) {
    header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "No type given.";
            exit();
}

$type = $_POST['content'];

$folder;
$upload_prefix = __DIR__ . "/../";
$full_path;
$file;
$dao = new accoladeDAO(new PDO(URL.DB, USER, PASS));

    switch ($type) {
        case "photo":
            $folder = "accolades/";
            
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
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

            if ($dao->Create(new Media("Photo", "", "", "", "", $folder . basename($_FILES['file']['name'])))) {
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
            
            break;
        case "video":
        $url = $_POST['path'];
        if (!isset($url)) {
         header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "No URL entered.";
            exit();
            }


            $media = new Media("Video", "", "", "", "", str_replace("watch?v=", "embed/", $url));
            if ($dao->create($media)) {
                    echo "Video Added Successfully!";
                }

            else {
                echo "Video add failed!";
                }

            break;
         default:
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-type: text/plain');
            echo "Selector not defined";
            exit();
            break;
    }

   