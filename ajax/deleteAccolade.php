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

// delete from DB, delete from directory



if (!isset($_POST['type'])) {
    echo "Type not specified!";
    exit();
}

$type = $_POST['type'];

$media = new Media("Accolade", "", "", "", $_POST['id'], $_POST['path']);

$dbDelete = ($accoladeDAO->Delete($media));

if ($type === "Photo") {


$fileDelete = unlink($media->path);

echo json_encode(["db" => $dbDelete, "path" => $fileDelete]);
}

else {
    echo json_encode(["db" => $dbDelete]);
}


