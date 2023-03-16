<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if(isset($_GET['positionID'])) {
    $id = $_GET['positionID'];

    $delete = $conn->prepare("DELETE FROM positions WHERE positionID = :positionID");
    $delete->bindParam(':positionID', $id);

    if($delete->execute()) {
        redirect("position.php", "Position deleted");
    }
}
?>