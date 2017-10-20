<?php
require_once __DIR__."/../php/daos/videoDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";

$videoDAO = new videoDAO(new PDO(URL.DB, USER, PASS));

//$id_pos = strpos($url, "v=");
//echo substr($url, $id_pos + 2);

$videos = $videoDAO->getAll();

foreach($videos as $key => $value) {
    $url = $videos[$key]["path"];
    $id_pos = strpos($url, "v=");
    $videos[$key]["thumb"] = "http://i.ytimg.com/vi/" . substr($url, $id_pos + 2) . "/0.jpg";
}


echo json_encode($videos, JSON_UNESCAPED_SLASHES);
//http://i.ytimg.com/vi/v1vDDXL6tK4/0.jpg