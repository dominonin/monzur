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

$videoDAO = new videoDAO(new PDO(URL.DB, USER, PASS));

// delete from DB, delete from directory

$media = new Media("Video", "", "", "", $_POST['id'], "");

$dbDelete = ($videoDAO->Delete($media));

echo json_encode(["db" => $dbDelete]);