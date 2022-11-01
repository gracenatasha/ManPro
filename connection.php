<?php
    // $servernamee = "localhost";
    // $usernamee = "admin";
    // $passwordd = "admin";
    // $db = "donor_darah";

    // $conn = mysqli_connect($servernamee,$usernamee,$passwordd,$db);
    // //check connection
    // if($conn->connect_error){
    //     die("ERROR: Could not connect. " .mysqli_connect_error());
    // }
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "donor_darah";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>