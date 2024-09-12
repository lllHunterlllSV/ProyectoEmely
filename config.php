<?php
$host = 'localhost';
$db = 'toefl';
$user = 'root';
$password = '';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
