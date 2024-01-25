<?php
include 'template/conexion.php';

$id_encuesta = $_GET['id_encuesta'];

$query = "UPDATE encuesta SET CantidadPreguntas = (SELECT COUNT(*) FROM preguntas WHERE Id_Encuesta = ?) WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $id_encuesta, $id_encuesta);
$stmt->execute();

echo "Encuesta actualizada correctamente";
?>
