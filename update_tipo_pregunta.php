<?php
include 'template/conexion.php';

$id = $_POST['id'];
$tipo = $_POST['tipo'];

$query = "UPDATE preguntas SET Id_tipo_pregunta = ? WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $tipo, $id);
$stmt->execute();

echo "Tipo de pregunta actualizado";
?>
