<?php
require_once __DIR__."/../php/connection.properties.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$user = $_POST["username"];
$pass = $_POST["password"];

$authData = new PDO(URL.DB, USER, PASS);

$stmt = $authData->prepare("SELECT pass FROM users WHERE username = ?");

if ($stmt->execute(array($user))) {
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if ($data["pass"] === $pass) {
        $_SESSION['user'] = $user;
        echo json_encode(array("URL" => "dash.php"));
    }

    else {
        echo json_encode(array("error" => "Invalid Credentials"));
    }
}

}

else if  ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_destroy();
}
