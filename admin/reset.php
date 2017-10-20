<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["password_change"]) || $_SESSION["password_change"] === false) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    echo "Not authorized to change password!";
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Password Reset</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

</head>

<body style="background-color: lightgrey;">


        <div class="container">


            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <h2 class="text-center">Change Password</h2>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-lg-offset-3">
                        <label for="pass">Enter New Password</label>
                        <input type="password" class="form-control" id="1">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-6 col-lg-offset-3">
                        <label for="confirmpass">Confirm New Password</label>
                        <input type="password" class="form-control" id="2">
                    </div>
                </div>

                <div class="row">
                    <div class=" col-lg-6 col-lg-offset-3">
                        <button type="submit" class="btn btn-default" id="update">Update</button>
                        <button class="btn btn-default" id="close">Close Window</button>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                <script src="../js/bootstrap.min.js"></script>
                <script src="../js/reset.js"></script>
                <script src="../js/SHA/sha.js"></script>
</body>

</html>