<?php
require_once __DIR__."/../php/daos/accoladeDAO.class.php";
require_once __DIR__."/../php/connection.properties.php";

$accoladeDAO = new accoladeDAO(new PDO(URL.DB, USER, PASS));

$accolades = $accoladeDAO->getAll();

foreach($accolades as $key => $value) {
    if ($accolades[$key]["type"] == "Video") {
    $url = $accolades[$key]["path"];
    $id_pos = strpos($url, "embed");
    $accolades[$key]["thumb"] = "http://i.ytimg.com/vi/" . substr($url, $id_pos + 6) . "/0.jpg";
}
}


echo json_encode($accolades, JSON_UNESCAPED_SLASHES);