<?php
require "../config/config.php";
require "../functions/function.php";
session_start();

if (isset($_POST['submit'])) {
  if (empty($_POST['email']) or empty($_POST['password'])) {
    redirects("../admins/login-admins.php", "some field is empty");

  } else {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $pass = 'password';

    $login = $conn->prepare("SELECT * FROM admins WHERE email = ? AND password = 'password'");
    $login->execute([$email]);

    if ($login->rowCount() > 0) {
      $data = $login->fetch(PDO::FETCH_ASSOC);

      $_SESSION['adminID'] = $data['adminID'];
      redirect("../admins/change-pass.php", "login successful");

    } else {

      $logins = $conn->prepare("SELECT * FROM admins WHERE email = ? AND password = ?");
      $logins->execute([$email, $password]);

      $datas = $logins->fetch(PDO::FETCH_ASSOC);

      if ($logins->rowCount() > 0) {
        $_SESSION['adminID'] = $datas['adminID'];
        redirect("../index.php", "login successful");

      } else {
        redirects("../admins/login-admins.php", "no user found");
      }
    }
  }
}