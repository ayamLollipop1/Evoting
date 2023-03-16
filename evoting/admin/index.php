<?php
require "config/config.php";
session_start();

if (!isset($_SESSION['adminID'])) {
  header("location: admins/login-admins.php");
} else {
  $adminID = $_SESSION['adminID'];
  $username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
  $username->execute();
  $name = $username->fetch(PDO::FETCH_ASSOC);
  $password = $name['password'];

  if ($password == 'password') {
    header("location: admins/change-pass.php");
  }
}

$adminID = $_SESSION['adminID'];
$username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
$username->execute();
$name = $username->fetch(PDO::FETCH_ASSOC);

$admins = $conn->prepare("SELECT COUNT(*) as alladmins FROM admins");
$admins->execute();
$data = $admins->fetch(PDO::FETCH_OBJ);

$students = $conn->prepare("SELECT COUNT(*) as allstudents FROM students");
$students->execute();
$dat = $students->fetch(PDO::FETCH_OBJ);

$candidates = $conn->prepare("SELECT COUNT(*) as allcandidates FROM candidates");
$candidates->execute();
$can = $candidates->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
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
              <a class="nav-link text-white" style="margin-left: 20px;" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="admins/admins.php" style="margin-left: 20px;">Admins</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="categories-admins/show-students.php" style="margin-left: 20px;">Students</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="positions/position.php" style="margin-left: 20px;">Positions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="candidates/search-candidate.php" style="margin-left: 20px;">Candidates</a>
            </li>
          </ul>
          <?php if (isset($_SESSION['adminID'])) : ?>
            <ul class="navbar-nav ml-md-auto d-md-flex">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link" href="admins/login-admins.html">login
                  <span class="sr-only">(current)</span>
                </a>
              </li>
            <?php endif; ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $name['firstName']. ' '. $name['Surname']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="admins/admin-logout.php">Logout</a>

            </li>


            </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              <p class="card-text">number of admins:
                <?php echo $data->alladmins; ?>
              </p>

            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Students</h5>

              <p class="card-text">number of students:
                <?php echo $dat->allstudents; ?>
              </p>

            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Candidates</h5>

              <p class="card-text">number of candidates:
                <?php echo $can->allcandidates; ?>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require "includes/footer.php"; ?>
</body>

</html>