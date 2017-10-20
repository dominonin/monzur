<?php
require_once __DIR__."/../php/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

if(!isset($_POST['id'])) {
    echo "Error: One or more data sets is not set!";
    exit();
}

$id = $_POST['id'];

$data = json_decode(file_get_contents(__DIR__."/../".$obj->{"faq"}));

unset($data->{"title"}[$id]);
unset($data->{"body"}[$id]);

$titles = array_values($data->{"title"});
$bodys = array_values($data->{"body"});

$data = array("title" => $titles, "body" => $bodys);

if (file_put_contents(__DIR__."/../".$obj->{"faq"}, json_encode($data)) === false) {
        echo json_encode("Error: Failed to write file!");
    }

    else {
        echo json_encode(array("db" => true));
    }