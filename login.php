<?php
require_once('function/function.php');
$resp = "";
if (isset($_POST['login_me'])) {
    // echo "hiiiii";
    // die();
    $resp = user_login();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="page-header">
            <h1 style="color: green" class="text-center mt-5">Login page</h1>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="login_form">
                    <?=$resp;?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username </label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email">

                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>&nbsp;

                        <button type="submit" name="login_me" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
</body>

</html>