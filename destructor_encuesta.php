<?php
include 'template/conexion.php';

if (isset($_POST['id_encuesta'])) {
  $encuestaID = $_POST['id_encuesta'];

  // Preparar la sentencia SQL
  $stmt = $conn->prepare("DELETE FROM encuesta WHERE ID = ?");

  // Vincular los parámetros
  $stmt->bind_param('i', $encuestaID);

  // Ejecutar la sentencia
  $stmt->execute();

  echo "Encuesta eliminada con éxito";
} else {
  echo "Error: id_encuesta no está definido";
}
?>
