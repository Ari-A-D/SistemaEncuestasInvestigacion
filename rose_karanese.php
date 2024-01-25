<?php
session_start();
if (!isset($_SESSION['dni'])) {
  // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión
  header("Location: acceso_creador.php");
  exit();
}

include "template/conexion.php";

// Obtiene el ID de la encuesta de la URL
$id_encuesta = $_GET['id_encuesta'];

// Prepara y ejecuta la consulta para obtener los detalles de la encuesta y el ID del usuario
$sql = $conn->prepare("SELECT encuesta.*, usuarios.ID as idUsuario FROM encuesta JOIN usuarios ON encuesta.id_usuario = usuarios.ID WHERE encuesta.ID = ? AND usuarios.dni = ?");
$sql->bind_param('is', $id_encuesta, $_SESSION['dni']);
$sql->execute();
$result = $sql->get_result();

// Comprueba si hay resultados
if ($result->num_rows > 0) {
    include 'dashboard_encuesta.php';
} else {
  // Cierra la conexión
  $conn->close();
  // Si no hay resultados, redirige al usuario a una página de error o a la página principal
  header("Location: /");
  exit;
}
?>