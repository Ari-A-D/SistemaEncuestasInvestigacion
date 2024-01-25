<?php
session_start();
if (!isset($_SESSION['dni'])) {
  // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión
  header("Location: acceso_creador.php");
  exit();
}
// Obtiene el texto y el DNI del usuario de los datos POST
$nombre = $_POST['nombre'];  // Asegúrate de que estás obteniendo 'nombre' de $_POST
$descripcion = $_POST['descripcion'];  // Asegúrate de que estás obteniendo 'nombre' de $_POST
$objetivo = $_POST['objetivo'];  // Asegúrate de que estás obteniendo 'nombre' de $_POST
$fecha = $_POST['fecha'];  // Asegúrate de que estás obteniendo 'nombre' de $_POST
$id_usuario = $_POST['id_usuario'];  // Asegúrate de que estás obteniendo 'nombre' de $_POST

include 'template/conexion.php';
// Prepara la consulta SQL
$sql = "INSERT INTO encuesta (Nombre, Descripcion, Objetivo, Fecha, Id_usuario) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre, $descripcion, $objetivo, $fecha, $id_usuario);

// Ejecuta la consulta SQL
if ($stmt->execute()) {
  echo "success";
} else {
  echo "error";
}

$stmt->close();
$conn->close();
