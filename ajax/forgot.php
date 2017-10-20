<?php
require_once __DIR__."/../php/connection.properties.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$secQ = new PDO(URL.DB, USER, PASS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!isset($_POST['answers'])) {
    echo json_encode(array("error" => "Security Questions can't be blank"));
    exit();
}

$answers = $_POST["answers"];

$stmt = $secQ->prepare("SELECT answer FROM questions");

if ($stmt->execute()) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pass = true;

    for($i = 0; $i < 3; $i++) {
        if ($data[$i]["answer"] !== $answers[$i]) {
            $pass = false;
        }
    }

    $_SESSION["password_change"] = $pass;

    echo json_encode(array("reset" => $pass));
}

else {
    echo "Failed to retrieve data";
}

}

else if  ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $secQ->prepare("SELECT question FROM questions");

if ($stmt->execute()) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   echo json_encode($data);
}

else {
    echo "Failed to retrieve data";
}
}

