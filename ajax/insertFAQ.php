<?php
require_once __DIR__."/../php/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

if(!isset($_POST['title']) || !isset($_POST['caption'])) {
    echo "Error: One or more data sets is not set!";
    exit();
}

$title = $_POST['title'];
$body = $_POST['caption'];

$data = json_decode(file_get_contents(__DIR__."/../".$obj->{"faq"}));

array_push($data->{"title"}, $title);
array_push($data->{"body"}, $body);

if (file_put_contents(__DIR__."/../".$obj->{"faq"}, json_encode($data)) === false) {
        echo json_encode("Error: Failed to write file!");
    }

    else {
        echo "true";
    }