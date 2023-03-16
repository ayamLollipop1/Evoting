<?php

require "../config/config.php";
require "../functions/function.php";
session_start();

if (!isset($_SESSION['adminID'])) {
    header("location: ../admins/login-admins.php");
}


if (isset($_GET['studentID']) && !empty($_GET['studentID'])) {
    $id = $_GET['studentID'];
    $stmt_eidt = $conn->prepare('DELETE FROM students WHERE studentID=:uid');

    if ($stmt_eidt->execute(array(':uid' => $id))) {
        redirect("../categories-admins/show-students.php", "student deleted successfully");
    }
} else {
    redirect("../categories-admins/show-students.php", "student id is missing from url");
}

require "../includes/footer.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afterworld</title>
     <!-- Alertify js -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
</head>
<body>
    
</body>
</html>