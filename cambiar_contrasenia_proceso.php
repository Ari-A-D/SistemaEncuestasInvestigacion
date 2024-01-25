<?php
include 'template/conexion.php';

// Obtener la nueva contraseña del formulario
$password = $_POST['password'];
$token = $_POST['token'];

// Crear un hash de la nueva contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE usuarios SET Contrasenia = ? WHERE codigo_activacion = ?");
$stmt->bind_param("ss", $hashed_password, $token);
$stmt->execute();

// Eliminar o invalidar el token
$stmt = $conn->prepare("UPDATE usuarios SET codigo_activacion = '' WHERE codigo_activacion = ?");
$stmt->bind_param("s", $token);
$stmt->execute();

echo "Tu contraseña ha sido restablecida exitosamente.";
?>
