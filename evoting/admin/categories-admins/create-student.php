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

$department = $conn->prepare("SELECT * FROM department");
$department->execute();
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
                <a class="navbar-brand" href="#">TTI VOTING SYSTEM</a>
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
                                <a class="dropdown-item" href="../admins/admin-logout.php">Logout</a>

                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h5 class="card-header">Add Student</h5>
                        <div class="card-body">
                            <form method="POST" action="../backends/add-student.php" autocapitalize="yes" autocomplete="no">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First name</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="othername">Other name</label>
                                            <input type="text" name="othername" id="othername" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="surname">Surname</label>
                                            <input type="text" name="surname" id="surname" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>House</label>
                                            <select name="house" class="form-control" required>
                                                <option value="">Select house</option>
                                                <option value="1">house 1</option>
                                                <option value="2">house 2</option>
                                                <option value="3">house 3</option>
                                                <option value="4">house 4</option>
                                                <option value="5">house 5</option>
                                                <option value="6">house 6</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select name="department" class="form-control" id="department" required>
                                                <option value="">Select department</option>
                                                <?php if ($department->rowCount() > 0) {
                                                    foreach ($department as $row) : ?>
                                                        <option value="<?php echo $row['dept_id'];?>"><?php echo $row['name'];?></option>
                                                <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                            <select name="class" id="classs" class="form-control" required>
                                                <option value="">Select class</option>
                                                <option value="form 1">Form 1</option>
                                                <option value="form 2">Form 2</option>
                                                <option value="form 3">Form 3</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="male">Male</label>
                                            <input type="radio" value="M" name="sex" id="male">
                                            <label for="male">Female</label>
                                            <input type="radio" value="F" name="sex" id="male">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-primary text-center">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require "../includes/footer.php"; ?>
</body>

</html>