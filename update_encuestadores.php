<?php
 include 'template/conexion.php';

 // Recibir los datos de la solicitud AJAX
 $id = $_POST['id'];
 $atributo = $_POST['atributo'];
 $valor = $_POST['valor'];

 // Preparar la consulta SQL
 $query = "UPDATE encuestadores SET $atributo = ? WHERE ID = ?";

 // Preparar la declaración
 $stmt = $conn->prepare($query);

 // Vincular los parámetros
 $stmt->bind_param('si', $valor, $id);

 // Ejecutar la consulta
 $stmt->execute();

 // Enviar una respuesta al cliente
 echo "Ha sido actualizado";
?>
