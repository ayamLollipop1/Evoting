<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['position'])) {
        redirects("../positions/create-position.php", "Input field is empty");
    } else {
        $position = sanitizeInput(ucwords($_POST['position']));

        $check = $conn->prepare("SELECT * FROM positions WHERE name = ?");
        $check->execute([$position]);

        if ($check->rowCount() > 0) {
            redirects("../positions/create-position.php", "Position already exists");
        } else {

            $insert = $conn->prepare("INSERT INTO positions (name, added_by) VALUES (:name, :added_by)");
            $insert->bindParam(':name', $position);
            $insert->bindParam(':added_by', $_SESSION['adminID']);

            if ($insert->execute()) {
                redirect("../positions/position.php", "Position added successfully");
            } else {
                redirect("../positions/position.php", "Failed to add position");
            }
        }
    }
}

require "../includes/footer.php";
