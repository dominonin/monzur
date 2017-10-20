<?php
require_once __DIR__."/../php/daos/photoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";

$photoDAO = new photoDAO(new PDO(URL.DB, USER, PASS));

echo json_encode($photoDAO->getAll(), JSON_UNESCAPED_SLASHES);