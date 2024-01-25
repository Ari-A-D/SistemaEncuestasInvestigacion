<?php
include 'template/conexion.php';

$id = $_POST['id'];
$detalle = $_POST['detalle'];

$query = "UPDATE respuestas SET Detalle = ? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $detalle, $id);
$stmt->execute();

echo "Respuesta actualizada correctamente";
?>
