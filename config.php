<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "mood2do";

$config = mysqli_connect($host, $user, $pass, $db);

if (!$config) {
    die("Conexión fallida: " . mysqli_connect_error());
}

?>
