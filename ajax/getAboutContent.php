<?php
require_once __DIR__."/../php/config.php";

$data = ["image_path" => $obj->{"about-img"}, "about_body" => file_get_contents(__DIR__."/../".$obj->{"about-body"})];

echo json_encode($data, JSON_UNESCAPED_SLASHES);