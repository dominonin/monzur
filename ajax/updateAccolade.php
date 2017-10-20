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

$accoladeDAO = new accoladeDAO(new PDO(URL.DB, USER, PASS));

$selectedMedia = new Media("Accolade", $_POST['title'], $_POST['caption'], $_POST['year'], $_POST['id'], "");

echo json_encode($accoladeDAO->Update($selectedMedia));