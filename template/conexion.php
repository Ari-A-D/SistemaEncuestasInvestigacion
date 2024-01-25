<?php
// Archivo de configuración
require_once 'sina.php';
$conn = mysqli_init();
mysqli_real_connect($conn, $servername, $username, $password, $dbname);
// Verificar conexión
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>
