<?php
require "../config/config.php";
session_start();

$allcandidates = $conn->prepare("SELECT * FROM candidates");
$allcandidates->execute();

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
                            <a class="nav-link" href="../positions/position.php" style="margin-left: 20px;">Positions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="search-candidate.php" style="margin-left: 20px;">Candidates</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-md-auto d-md-flex">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <h5 class="card-title mb-4 d-inline">Candidates</h5>
                            <a href="create-candidate.php" class="btn btn-primary mb-4 text-center float-right">Create Candidate</a>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">first name</th>
                                        <th scope="col">othername</th>
                                        <th scope="col">surname</th>
                                        <th scope="col">image</th>
                                        <th scope="col">position</th>
                                        <th scope="col">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($allcandidates->rowCount() > 0) {
                                        foreach ($allcandidates as $row) :
                                            $stdID = $row['studentID'];
                                            $pstID = $row['positionID'];

                                            $std_details = $conn->prepare("SELECT * FROM students WHERE studentID='$stdID'");
                                            $std_details->execute();
                                            $details = $std_details->fetch(PDO::FETCH_OBJ);

                                            $pst_details = $conn->prepare("SELECT * FROM positions WHERE positionID='$pstID'");
                                            $pst_details->execute();
                                            $detail = $pst_details->fetch(PDO::FETCH_OBJ);

                                    ?>
                                            <tr>
                                                <td scope="row"><?php echo $row['candidateID']; ?></td>
                                                <td scope="row"><?php echo $details->firstname; ?></td>
                                                <td scope="row"><?php echo $details->othername; ?></td>
                                                <td scope="row"><?php echo $details->surname; ?></td>
                                                <td scope="row"><img width="50px" src="uploads/<?php echo $row['image']; ?>" alt=""></td>
                                                <td scope="row"><?php echo $detail->name; ?></td>
                                                <td><a href="#"><i class="fa fa-trash btn btn-danger" style="font-size:30px;"></i></a>
                                                    <a href="#"><i class="fa fa-edit btn btn-warning" style="font-size:30px;"></i></a>
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