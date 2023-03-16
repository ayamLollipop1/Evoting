<?php 
require "../config/config.php";
require "../functions/function.php";
session_start();

if(isset($_POST['submit'])) {
    if(empty($_POST['email']) or empty($_POST['fname']) or empty($_POST['sname'])) {
        redirects("../admins/create-admins.php", "some field is empty");
    } else {

        $email = $_POST['email'];
        $firstName = $_POST['fname'];
        $Surname = $_POST['sname'];
        // $password = md5($_POST['password']);

        $check = $conn->prepare("SELECT * FROM admins WHERE email = ? ");
        $check->execute([$email]);

        if($check->rowCount() >0) {
            redirects("../admins/create-admins.php", "user already exist");
        } else {
            $insert = $conn->prepare("INSERT INTO admins (`email`, `firstName`, `Surname`) VALUES (:email, :firstName, :Surname)");
            $insert->bindParam(':email', $email);
            $insert->bindParam(':firstName', $firstName);
            $insert->bindParam(':Surname', $Surname);
            // $insert->bindParam('password', $password);

            if($insert->execute()) {
                redirect("../admins/admins.php", "admin created successfully");
            }

        }
    }
}

require "../includes/footer.php";

?>