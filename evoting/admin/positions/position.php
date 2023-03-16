<?php
require "../config/config.php";
session_start();

if (!isset($_SESSION['adminID'])) {
  header("location: ../admins/login-admins.php");
}

$allpositions = $conn->prepare("SELECT * FROM positions");
$allpositions->execute();

$adminID = $_SESSION['adminID'];
$username = $conn->prepare("SELECT * FROM admins WHERE adminID = $adminID");
$username->execute();
$name = $username->fetch(PDO::FETCH_ASSOC);
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
            <li class="nav-item">
              <a class="nav-link" href="../candidates/search-candidate.php" style="margin-left: 20px;">Candidates</a>
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
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Positions</h5>
              <a href="create-position.php" class="btn btn-primary mb-4 text-center float-right">Add Position</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">position name</th>
                    <th scope="col">added by</th>
                    <th scope="col">action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($allpositions->rowCount() > 0) {
                    $count = 0;
                    foreach ($allpositions as $row) :
                      $count++;
                      $add = $row['added_by'];
                      $added = $conn->prepare("SELECT * FROM admins WHERE adminID='$add'");
                      $added->execute();
                      $by = $added->fetch(PDO::FETCH_OBJ);
                  ?>
                      <tr>
                        <td scope="row"><?php echo $count; ?></td>
                        <td scope="row"><?php echo $row['name']; ?></td>
                        <td scope="row"><?php echo $by->firstName; ?></td>
                        <td><a href="delete_position.php?positionID=<?php echo $row['positionID']; ?>"><i class="fa fa-trash btn btn-danger" style="font-size:30px;"></i></a>
                          <a href="update-position.php?positionID=<?php echo $row['positionID']; ?>"><i class="fa fa-edit btn btn-warning" style="font-size:30px;"></i> </a>
                        </td>
                      </tr>
                  <?php
                    endforeach;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php require "../includes/footer.php"; ?>
</body>

</html>