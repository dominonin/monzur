<?php
require_once __DIR__."/../php/daos/photoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";
require_once __DIR__."/../php/models/Media.class.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

$photoDAO = new photoDAO(new PDO(URL.DB, USER, PASS));

// delete from DB, delete from directory

$media = new Media("Photo", "", "", "", $_POST['id'], $_POST['path']);

$dbDelete = ($photoDAO->Delete($media));
$fileDelete = unlink($media->path);

echo json_encode(["db" => $dbDelete, "path" => $fileDelete]);