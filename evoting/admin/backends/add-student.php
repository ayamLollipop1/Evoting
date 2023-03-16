<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (isset($_POST['submit'])) {
    if (
        empty($_POST['firstname']) || empty($_POST['surname']) || empty($_POST['house']) ||
        empty($_POST['department']) || empty($_POST['class'])
    ) {
        redirects("../categories-admins/create-student.php", "Please fill required fields");
    } else {

        $firstname  = sanitizeInput(ucfirst($_POST['firstname']));
        $othername  = sanitizeInput(ucfirst($_POST['othername']));
        $surname    = sanitizeInput(ucfirst($_POST['surname']));
        $house      = sanitizeInput(ucfirst($_POST['house']));
        $department = sanitizeInput(ucwords ($_POST['department']));
        $class      = sanitizeInput(ucfirst($_POST['class']));
        $sex        = sanitizeInput(ucfirst($_POST['sex']));
        $uniqueCode = $uniqueCode;
        

        $check = $conn->prepare("SELECT * FROM students WHERE uniqueCode = ? ");
        $check->execute([$uniqueCode]);

        if ($check->rowCount() > 0) {
            redirects("../categories-admins/create-student.php", "Unique code already exist");
        } else {

            $checks = $conn->prepare("SELECT * FROM students WHERE firstname = ? AND othername = ? AND surname = ? 
            AND class = ? AND department_id = ? AND sex = ? AND house = ?");
            $checks->execute([$firstname, $othername, $surname, $class, $department, $sex, $house]);

            if ($checks->rowCount() > 0) {
                redirects("../categories-admins/create-student.php", "Student already exist");
            } else {

                $insert = $conn->prepare("INSERT INTO students (firstname, othername, surname, house, department_id, class,
            uniqueCode, sex) VALUES (:firstname, :othername, :surname, :house, :department_id, :class, :uniqueCode, :sex)");

                $insert->bindParam(':firstname', $firstname);
                $insert->bindParam(':othername', $othername);
                $insert->bindParam(':surname', $surname);
                $insert->bindParam(':house', $house);
                $insert->bindParam(':department_id', $department);
                $insert->bindParam(':class', $class);
                $insert->bindParam(':uniqueCode', $uniqueCode);
                $insert->bindParam(':sex', $sex);

                if ($insert->execute()) {
                    redirect("../categories-admins/show-students.php", "sudent added successfully");
                }
            }
        }
    }
}



require "../includes/footer.php";
