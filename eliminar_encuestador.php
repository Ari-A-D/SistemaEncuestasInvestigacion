<?php
include 'template/conexion.php';

// Recibir los datos de la solicitud AJAX
$id = $_POST['id'];

// Desactivar las comprobaciones de clave foránea
$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

// Preparar la consulta SQL
$query = "DELETE FROM encuestadores WHERE ID = ?";

// Preparar la declaración
$stmt = $conn->prepare($query);

// Vincular los parámetros
$stmt->bind_param('i', $id);

// Ejecutar la consulta
$stmt->execute();

// Reactivar las comprobaciones de clave foránea
$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

// Enviar una respuesta al cliente
echo "Respuesta eliminada correctamente";
?>
