<?php 

function redirect($url, $message) {
    $_SESSION['message'] = $message;
     header('location: '.$url);
     exit();
}

function redirects($url, $warning) {
    $_SESSION['warning'] = $warning;
    header('location: '.$url);
    exit();
}
 
function generate_unique_id($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $unique_id = '';

    // Choose a random letter to be the first character of the unique ID
    $unique_id .= chr(rand(65, 90));

    for ($i = 1; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $unique_id .= $characters[$index];
    }

    return $unique_id;
}

$uniqueCode = generate_unique_id(10);

function sanitizeInput($data)
{
    $data = trim($data, " ");
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>