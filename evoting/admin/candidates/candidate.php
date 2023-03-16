<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (!isset($_SESSION['adminID'])) {
  header("location: ../admins/login-admins.php");
}

$position = $conn->prepare("SELECT * FROM positions");
$position->execute();

if (isset($_GET['studentID'])) {
  $id = $_GET['studentID'];

  $student = $conn->prepare("SELECT * FROM students WHERE studentID='$id'");
  $student->execute();
}

$adminID = $_SESSION['adminID'];
$username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
$username->execute();
$name = $username->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {

  $check = $conn->prepare("SELECT * FROM candidates WHERE studentID = ?");
  $check->execute([$id]);

  if ($check->rowCount() > 0) {
    redirects("search-candidate.php", "Candidate already exists");
  } else {
    $positionID = $_POST['positionID'];
    $id = $_POST['id'];

    $image = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];

    $upload_dir = 'uploads/';
    $imgExt = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png');
    $image = rand(1000, 1000000) . "." . $imgExt;
    move_uploaded_file($tmp_dir, $upload_dir . $image);


    $insert = $conn->prepare("INSERT INTO candidates (studentID, `image`, positionID, added_by)
   VALUES (:studentID, :image, :positionID, :added_by)");

    $insert->bindParam(':studentID', $id);
    $insert->bindParam(':image', $image);
    $insert->bindParam(':positionID', $positionID);
    $insert->bindParam(':added_by', $_SESSION['adminID']);

    if ($insert->execute()) {
      redirect("search-candidate.php", "Candidate added successful");
    } else {
      redirects("search-candidate.php", "Failded to add candidate");
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
            <h5 class="card-header">Add Candidate</h5>
            <div class="card-body">

              <?php if ($student->rowCount() > 0) :
                $info = $student->fetch(PDO::FETCH_ASSOC);
                $firstname = $info['firstname'];
                $othername = $info['othername'];
                $surname = $info['surname'];
                $house = $info['house'];
                $department = $info['department'];
                $class = $info['class'];
                $id = $info['studentID'];
              ?>
                <form method="POST" action="candidate.php" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="">First name</label>
                      <div class="form-group">
                        <input type="text" disabled value="<?php echo $firstname; ?>" name="firstname" id="form2Example1" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="">Other name</label>
                      <div class="form-group">
                        <input type="text" disabled value="<?php echo $othername; ?>" name="othername" id="form2Example1" class="form-control" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label for="">Surname</label>
                      <div class="form-group">
                        <input type="text" disabled value="<?php echo $surname; ?>" name="surname" id="form2Example1" class="form-control" />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>House</label>
                        <input type="text" disabled value="<?php echo $house; ?>" name="house" id="form2Example1" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Department</label>
                        <input type="text" disabled value="<?php echo $department; ?>" name="department" id="form2Example1" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Class</label>
                        <input type="text" disabled value="<?php echo $class; ?>" name="class" id="form2Example1" class="form-control" />
                      </div>
                    </div>
                    <!-- <div class="col-md-3">
                      <div class="form-group">
                        <label for="">Sex</label>
                        <input type="text" disabled value="<?php echo $sex; ?>" name="sex" id="form2Example1" class="form-control" />
                      </div>
                    </div> -->
                  </div>

                  <div class="form-group mb-4 mt-4">
                    <label for="">Position</label>
                    <select name="positionID">
                      <?php if ($position->rowCount() > 0) :
                        foreach ($position as $row) : ?>
                          <option value="<?php echo $row['positionID']; ?>"><?php echo $row['name']; ?></option>
                      <?php
                        endforeach;
                      endif; ?>
                    </select>

                    <label for="Image">Image</label>
                    <input type="file" name="image" id="Image">
                  </div>
                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require "../includes/footer.php"; ?>
</body>

</html>