<?php
require_once __DIR__."/../php/connection.properties.php";
require_once __DIR__."/../php/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['user'])) {
        echo "Not authorized!";
        exit();
    }

$order = $_POST['order'];
$table = $_POST['table'];

if ($table != "faq") {

$db = new PDO(URL.DB, USER, PASS);

$update = 0;

for ($i = 1; $i < count($order); $i++) {
    $update += $db->exec("UPDATE ".$table." SET position = $i WHERE id = $order[$i]");
}

echo $update;
}

else {
    $data = json_decode(file_get_contents(__DIR__."/../".$obj->{"faq"}));
    $titles = array_values($data->{"title"});
    $bodys = array_values($data->{"body"});
    $newTitles = array();
    $newBodies = array();

    for ($i = 1; $i < count($order); $i++) {
        array_push($newTitles, $titles[$order[$i]]);
        array_push($newBodies, $bodys[$order[$i]]);
    }

    $new = array("title" => $newTitles, "body" => $newBodies);

    if (file_put_contents(__DIR__."/../".$obj->{"faq"}, json_encode($new)) === false) {
        echo json_encode("Error: Failed to write file!");
    }

    else {
        echo "All";
    }

}