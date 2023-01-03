<?php

require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //$sql = "SELECT * From `pendonor` WHERE `email` = '$email' AND `password`=PASSWORD('$pass')";
    $sql = "SELECT * From `pendonor` WHERE `email` = '$email' AND `password`= '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = mysqli_fetch_assoc($result);
        $_SESSION['ini_session_blog'] = ".".$email.".";
        $_SESSION['id'] = $row["id_pendonor"];
        $_SESSION['name'] = $row["nama_pendonor"];
        header('location: userhome.php');
      } else {
        echo "0 results";
      }
}

?>