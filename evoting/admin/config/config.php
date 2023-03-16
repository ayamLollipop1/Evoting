<?php 

try {
   $host     = "localhost";
   $dbname   = "evoting";
   $user     = "root";
   $password = '';

   $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    $e->getMessage();
}

?>