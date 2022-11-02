<?php
$mysqli = new mysqli("servername", "username", "password", "dbname");
if($mysqli->connect_error) {
  exit('Could not connect');
}

$sql = "SELECT nama_pendonor, golongan_darah, rhesus, email FROM pendonor WHERE golongan_darah = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_GET['a']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($np, $gd, $rs, $email);
$stmt->fetch();
$stmt->close();
             
echo "<table>";
echo "<tr>";
echo "<th>Nama Pendonor</th>";
echo "<td>" . $np . "</td>";
echo "<th>Goldar</th>";
echo "<td>" . $gd . "</td>";
echo "<th>Rhesus</th>";
echo "<td>" . $rs . "</td>";
echo "<th>Email</th>";
echo "<td>" . $email . "</td>";
echo "</tr>";
echo "</table>";
?>
