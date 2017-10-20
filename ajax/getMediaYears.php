<?php
require_once __DIR__ . "/../php/daos/photoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";
require_once __DIR__ . "/../php/daos/videoDAO.class.php";
require_once __DIR__ . "/../php/daos/accoladeDAO.class.php";

$selection = $_POST['media'];
$dao;

switch ($selection) {
    case "photos":
        $dao = new PhotoDAO(new PDO(URL.DB, USER, PASS));
        echo json_encode($dao->getYears());
        break;

    case "videos":
        $dao = new VideoDAO(new PDO(URL.DB, USER, PASS));
        echo json_encode($dao->getYears());
        break;

    case "accolades":
        $dao = new AccoladeDAO(new PDO(URL.DB, USER, PASS));
        echo json_encode($dao->getYears());
        break;
    default: 
        echo "Incorrect Selection";
        break;
}