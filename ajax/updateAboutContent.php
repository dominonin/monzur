<?php
require_once __DIR__."/../php/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

if (!isset($_POST["about_body"])) {
    echo json_encode("Error: No data");
}

else {
    if (file_put_contents(__DIR__."/../".$obj->{"about-body"}, $_POST["about_body"]) === false) {
        echo json_encode("Error: Failed to write file!");
    }

    else {
        echo json_encode("Changes applied succesfully");
    }
}