<?php
$hostname = "localhost";
$username = "root";
$password = ""; 
$database = "mood2do";

$conexion = mysqli_connect($hostname, $username, $password, $database);

// Verificación simple
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>