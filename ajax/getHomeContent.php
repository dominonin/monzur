<?php
require_once __DIR__."/../php/config.php";

$data = ["home_img" => $obj->{"home-img"}, "home_audio" => $obj->{"home-audio"}, "home_video" => $obj->{"home-video"}, "top_heading" => $obj->{"top-heading"}, "lower_right_heading" => $obj->{"lower-right-heading"}, "bottom_heading" => $obj->{"bottom-heading"}];

echo json_encode($data, JSON_UNESCAPED_SLASHES);