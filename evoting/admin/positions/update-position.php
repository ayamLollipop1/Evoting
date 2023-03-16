<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (!isset($_SESSION['adminID'])) {
    header("location: ../admins/login-admins.php");
}

$adminID = $_SESSION['adminID'];
$username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
$username->execute();
$name = $username->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['positionID'])) {
    $id = $_GET['positionID'];

    $position = $conn->prepare("SELECT * FROM positions WHERE positionID = :positionID");
    $position->bindParam(':positionID', $id);
    $position->execute();
    $data = $position->fetch(PDO::FETCH_ASSOC);

}


        if (isset($_POST['submit'])) {
            if (
                empty($_POST['position_name'])
            ) {
                redirects("update-position.php?positionID=$id", "Please fill required fields");
            } else {

                $position_name = sanitizeInput($_POST['position_name']);

                $update = $conn->prepare("UPDATE positions SET `name`=:name");
                $update->bindParam(':name', $position_name);

                if ($update->execute()) {
                    redirect("position.php", "Position updated");
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
    <meta name="viewport" content="width=device-width, initial class=" form-control"-scale=1">
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
                        <li class="nav-item">
                            <a class="nav-link" style="margin-left: 20px;" href="../index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admins/admins.php" style="margin-left: 20px;">Admins</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../categories-admins/show-students.php" style="margin-left: 20px;">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="position.php" style="margin-left: 20px;">Positions</a>
                        </li>
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
                                <a class="dropdown-item" href="#">Logout</a>

                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h5 class="card-header text-center">Update Position</h5>
                        <div class="card-body">
                            <form method="POST" action="update-position.php?positionID=<?php echo $data['positionID']; ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Position name</label>
                                        <div class="form-group">
                                            <input type="text" value="<?php echo $data['name'];?>" name="position_name" id="form2Example1" class="form-control" placeholder="position name" r class="form-control" equired />
                                        </div>
                                    </div>
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