<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "maya_go_db";
$port = 3307;

$conn = new mysqli($host, $user, $password, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>