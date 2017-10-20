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


$selectedMedia = new Media("Video", $_POST['title'], $_POST['caption'], $_POST['year'], $_POST['id'], "");
echo json_encode($videoDAO->Update($selectedMedia));