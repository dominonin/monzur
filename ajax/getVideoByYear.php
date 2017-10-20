<?php
require_once __DIR__."/../php/daos/videoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";

$videoDAO = new videoDAO(new PDO(URL.DB, USER, PASS));

echo json_encode($videoDAO->getVideoByYear($_POST['year']), JSON_UNESCAPED_SLASHES);