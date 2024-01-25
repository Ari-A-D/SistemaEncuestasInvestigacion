<?php
include 'template/conexion.php';

if (isset($_POST['id_respuesta'])) {
  $respuestaID = $_POST['id_respuesta'];

  // Preparar la sentencia SQL
  $stmt = $conn->prepare("DELETE FROM respuestas WHERE ID = ?");

  // Vincular los parámetros
  $stmt->bind_param('i', $respuestaID);

  // Ejecutar la sentencia
  $stmt->execute();

  echo "Respuesta eliminada con éxito";
} else {
  echo "Error al eliminar la respuesta";
}
?>
