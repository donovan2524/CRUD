<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tareas_pendientes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

?>
