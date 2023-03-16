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

if (isset($_GET['studentID'])) {
    $id = $_GET['studentID'];

    $details = $conn->prepare("SELECT * FROM students s inner join department d on s.department_id = d.dept_id WHERE studentID=$id");
    // $details = $conn->prepare("SELECT studentID,firstname,othername,surname,house,department_id,class,sex,uniqueCode,dept_id,name FROM students LEFT JOIN department ON department_id = dept_id WHERE studentID = '$id'");
    $details->execute();
    $data = $details->fetch(PDO::FETCH_ASSOC);
}

// if (isset($_POST['submit'])) {
//     if (
//         empty($_POST['firstname']) || empty($_POST['surname']) || empty($_POST['house']) || 
//         empty($_POST['department_id']) || empty($_POST['house']) || empty($_POST['class']) || empty($_POST['sex'])
//     ) {
//         redirects("update-student.php?studentID=$id", "Please fill required fields");
//     } else {

//         $firstname = sanitizeInput($_POST['firstname']);
//         $othername = sanitizeInput($_POST['othername']);
//         $surname = sanitizeInput($_POST['surname']);
//         $house = sanitizeInput($_POST['house']);
//         $department_id = sanitizeInput($_POST['department_id']);
//         $class = sanitizeInput($_POST['class']);
//         $sex = sanitizeInput($_POST['sex']);

//         $update = $conn->prepare("UPDATE students SET firstname=:firstname, othername=:othername, surname=:surname,
//         house=:house,department_id=:department_id, class=:class, sex=:sex WHERE studentID=:studentID");
//         $update->bindParam(':firstname', $firstname);
//         $update->bindParam(':othername', $othername);
//         $update->bindParam(':surname', $surname);
//         $update->bindParam(':house', $house);
//         $update->bindParam(':department_id', $department_id);
//         $update->bindParam(':class', $class);
//         $update->bindParam(':sex', $sex);
//         $update->bindParam(':studentID', $id);

//         if($update->execute()) {
//             redirect("show-students.php", "Student record updated");
//         }
//     }
// }

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
                        <h5 class="card-header">Update Student's record</h5>
                        <div class="card-body">
                            <form method="POST" action="../backends/update-student.php?studentID=<?php echo $data['studentID'];?>" autocapitalize="yes" autocomplete="no">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="studentID" value="<?php echo $data['studentID']; ?>">
                                        <div class="form-group">
                                            <label for="firstname">First name</label>
                                            <input type="text" value="<?php echo $data['firstname']; ?>" name="firstname" id="firstname" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="othername">Other name</label>
                                            <input type="text" value="<?php echo $data['othername']; ?>" name=" othername" id="othername" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="surname">Surname</label>
                                            <input type="text" value="<?php echo $data['surname']; ?>" name="surname" id="surname" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>House</label>
                                            <select name="house" class="form-control" required>
                                                <option value="<?php echo $data['house']; ?>"><?php echo $data['house']; ?></option>
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
                                            <select name="department_id" class="form-control" id="department" required>
                                                <option value="<?php echo $data['dept_id']; ?>"><?php echo $data['name']; ?></option>
                                                <?php if ($department->rowCount() > 0) {
                                                    foreach ($department as $row) : ?>
                                                        <option value="<?php echo $row['dept_id']; ?>"> <?php echo $row['name']; ?></option>
                                                <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                            <select name="class" id="classs" class="form-control" required>
                                                <option value="<?php echo $data['class']; ?>"><?php echo $data['class']; ?></option>
                                                <option value="form 1">Form 1</option>
                                                <option value="form 2">Form 2</option>
                                                <option value="form 3">Form 3</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="sex">Sex</label>
                                            <select name="sex" id="sex" class="form-control" required>
                                                <option value="<?php echo $data['sex']; ?>"><?php echo $data['sex']; ?></option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-primary text-center">Save </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require "../includes/footer.php"; ?>
</body>

</html>