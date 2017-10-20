<?php
require_once __DIR__."/../php/connection.properties.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["password_change"]) || $_SESSION["password_change"] === false) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    echo "Not authorized to change password!";
    exit();

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!isset($_POST['password']) || $_POST['password'] === "") {
    echo "blank";
    exit();
}

$pm = new PDO(URL.DB, USER, PASS);

$pass = $_POST["password"];

$stmt = $pm->prepare("UPDATE users SET pass = ? WHERE username = 'admin'");

if ($stmt->execute(array($pass))) {
    echo "Password Updated Successfully.";
    session_destroy();
}

else {
    echo "Failed to update password";
    session_destroy();
}

}