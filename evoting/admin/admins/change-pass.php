<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (!isset($_SESSION['adminID'])) {
    header("location: login-admins.php");
} else {
    $adminID = $_SESSION['adminID'];
    $username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
    $username->execute();
    $name = $username->fetch(PDO::FETCH_ASSOC);
    $password = $name['password'];

    if ($password != 'password') {
        header("location: ../index.php");
    }
}

$adminID = $_SESSION['adminID'];
$username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
$username->execute();
$name = $username->fetch(PDO::FETCH_ASSOC);

$admin = $conn->prepare("SELECT * FROM admins WHERE adminID='$adminID'");
$admin->execute();

if (isset($_POST['submit'])) {
    if (empty($_POST['password'])) {
        redirects("change-pass.php", "password field is empty");
    } else {
        $password = md5($_POST['password']);

        $update = $conn->prepare("UPDATE admins SET `password`=:password WHERE adminID='$_SESSION[adminID]'");
        $update->bindParam(':password', $password);

        if ($update->execute()) {
            redirect("../index.php", "password changed successfully");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Alertify js -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
</head>

<body>
    <div id="wrapper">
        <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">LOGO</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav side-nav">
                        <!-- <li class="nav-item">
                            <a class="nav-link" style="margin-left: 20px;" href="../index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="admins.php" style="margin-left: 20px;">Admins</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="../categories-admins/show-students.php" style="margin-left: 20px;">Students</a>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav ml-md-auto d-md-flex">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $name['firstName'] . ' ' . $name['Surname']; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="admin-logout.php">Logout</a>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-5 d-inline">Change password</h5>

                            <?php $details = $admin->fetch(PDO::FETCH_OBJ); ?>
                            <form method="POST" action="change-pass.php" enctype="multipart/form-data">
                                <!-- Email input -->
                                <div class="form-outline mb-4 mt-4">
                                    <input type="email" name="email" disabled value="<?php echo $details->email; ?>" id="form2Example1" class="form-control" placeholder="email" />

                                </div>

                                <div class="form-outline mb-4">
                                    <input type="name" name="fname" disabled value="<?php echo $details->firstName; ?>" id="form2Example1" class="form-control" placeholder="first name" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="name" name="sname" disabled id="form2Example1" value="<?php echo $details->Surname; ?>" class="form-control" placeholder="surname" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require "../includes/footer.php"; ?>
</body>

</html>