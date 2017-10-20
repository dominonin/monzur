<?php
require_once __DIR__."/../php/config.php";

$data = file_get_contents(__DIR__."/../".$obj->{"footer"});

echo json_encode($data, JSON_UNESCAPED_SLASHES);