<?php
require_once __DIR__."/../php/connection.properties.php";

$pdo = new PDO(URL.DB, USER, PASS);

$photosCount = $pdo->prepare("SELECT COUNT(id) FROM photos");
$videosCount = $pdo->prepare("SELECT COUNT(id) FROM videos");
$accoladesCount = $pdo->prepare("SELECT COUNT(id) FROM accolades");

$photosCount->execute();
$videosCount->execute();
$accoladesCount->execute();

echo json_encode(["photos" => $photosCount->fetch(), "videos" => $videosCount->fetch(), "accolades" => $accoladesCount->fetch()]);