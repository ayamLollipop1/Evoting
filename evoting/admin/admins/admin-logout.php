<?php

require "../config/config.php";
require "../functions/function.php";
session_start();

if(isset($_SESSION['adminID'])) {
    header('location: ../index.php');
}

if (isset($_SESSION['adminID'])) {
    unset($_SESSION['adminID']);
    // session_destroy();
    redirect("login-admins.php", "logout successful");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>afterworld-logout</title>
    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">
    <!-- Alertify js -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
</head>

<body>

<?php require "../includes/footer.php"; ?>
</body>
</html>