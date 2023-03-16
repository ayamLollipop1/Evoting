<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (isset($_GET['studentID'])) {
    $id = $_GET['studentID'];

    $details = $conn->prepare("SELECT * FROM students s inner join department d on s.department_id = d.dept_id WHERE studentID=$id");
    // $details = $conn->prepare("SELECT studentID,firstname,othername,surname,house,department_id,class,sex,uniqueCode,dept_id,name FROM students LEFT JOIN department ON department_id = dept_id WHERE studentID = '$id'");
    $details->execute();
    $data = $details->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    if (
        empty($_POST['firstname']) || empty($_POST['surname']) || empty($_POST['house']) ||
        empty($_POST['department_id']) || empty($_POST['house']) || empty($_POST['class']) || empty($_POST['sex'])
    ) {
        redirects("../categories-admins/create-student.php", "Please fill required fields");
    } else {

        $firstname = sanitizeInput($_POST['firstname']);
        $othername = sanitizeInput($_POST['othername']);
        $surname = sanitizeInput($_POST['surname']);
        $house = sanitizeInput($_POST['house']);
        $department_id = sanitizeInput($_POST['department_id']);
        $class = sanitizeInput($_POST['class']);
        $sex = sanitizeInput($_POST['sex']);

        $update = $conn->prepare("UPDATE students SET firstname=:firstname, othername=:othername, surname=:surname,
        house=:house,department_id=:department_id, class=:class, sex=:sex WHERE studentID=:studentID");
        $update->bindParam(':firstname', $firstname);
        $update->bindParam(':othername', $othername);
        $update->bindParam(':surname', $surname);
        $update->bindParam(':house', $house);
        $update->bindParam(':department_id', $department_id);
        $update->bindParam(':class', $class);
        $update->bindParam(':sex', $sex);
        $update->bindParam(':studentID', $id);

        if ($update->execute()) {
            redirect("../categories-admins/show-students.php", "Student record updated");
        }
    }
}

?>