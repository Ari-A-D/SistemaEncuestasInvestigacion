<?php
include 'template/conexion.php';
// Obtener el código de activación de la URL
$activation_code = $_GET['code'];

// Preparar la consulta SQL
$stmt = $conn->prepare("UPDATE usuarios SET activado = 1 WHERE codigo_activacion = ?");
$stmt->bind_param("s", $activation_code);

// Ejecutar la consulta
if ($stmt->execute() === TRUE) {
 echo "Cuenta activada";
} else {
 echo "Error al activar la cuenta";
}

// Cerrar la conexión
$conn->close();
?>
