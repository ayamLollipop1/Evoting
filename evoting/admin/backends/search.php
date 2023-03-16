<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evoting - Serach</title>
    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

</body>

</html>
<?php

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = $conn->prepare("SELECT * FROM students WHERE firstname LIKE '{$input}%' OR 
    othername LIKE '{$input}%' OR surname LIKE '{$input}%' OR uniqueCode LIKE '{$input}%'");
    $query->execute();

    if ($query->rowCount() > 0) {
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $firstname = $result['firstname'];
        $othername = $result['othername'];
        $surname = $result['surname'];
        $department = $result['department'];
        $house = $result['house'];
        $class = $result['class'];
        $id = $result['studentID'];
?>
        <table class="table table-bordered tabel-striped mt-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>first name</th>
                    <th>othername</th>
                    <th>surname</th>
                    <th>department</th>
                    <th>house</th>
                    <th>class</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $firstname; ?></td>
                    <td><?php echo $othername; ?></td>
                    <td><?php echo $surname; ?></td>
                    <td><?php echo $department; ?></td>
                    <td><?php echo $house; ?></td>
                    <td><?php echo $class; ?></td>
                    <td><a href="../candidates/candidate.php?studentID=<?php echo $id;?>"><i class="fa fa-plus btn btn-danger"></a></i></td>
                </tr>
            </tbody>
            </tabel>
    <?php

    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}

require "../includes/footer.php";
    ?>