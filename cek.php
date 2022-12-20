<?php

require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * From `user` WHERE `email` = '$email' AND `password`=PASSWORD('$pass')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['ini_session_blog'] = ".".$email.".";
        header('location: Filter.php');
      } else {
        echo "0 results";
      }
}

?>