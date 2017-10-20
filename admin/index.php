<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    if (isset($_SESSION['user'])) {
        header("Location: dash.php");
    }
?>

        <div class="container">
            <div class="row">
                <div class="col-lg-offset-8 col-lg-4">
                    <div style="text-align: center" class="form-login">
                        <h4>Control Panel</h4>
                        <div id="text"></div>
                        <input type="text" id="userName" class="form-control input-sm chat-input" placeholder="username" />
                        </br>
                        <input type="password" id="userPassword" class="form-control input-sm chat-input" placeholder="password" />
                        </br>
                        <div class="wrapper">
                            <span class="group-btn">     
                <a href="#" class="btn btn-primary btn-md">login <i class="fa fa-sign-in"></i></a>
            </span>

                        </div>
                        <a href="javascript:void(0);" id="forgot">Forgot Password</a>
                    </div>

                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/login.js"></script>
        <script src="../js/SHA/sha.js"></script>
</body>

</html>