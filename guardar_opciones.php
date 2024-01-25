<?php
include 'template/conexion.php';
// Obtener las opciones del POST
$opciones = $_POST['opciones'];
$id_pregunta = $_POST['id_pregunta'];
$valor ='';
$success = true;
// Insertar cada opción como una fila en la base de datos
foreach ($opciones as $opcion) {
  $sql = "INSERT INTO respuestas (Detalle, Valor, Id_Pregunta) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $opcion, $valor, $id_pregunta);
  if (!$stmt->execute()) {
    $success = false;
    echo "Error: " . $stmt->error;
  }
  $stmt->close();
}
if ($success) {
  echo "success";
} else {
  echo "error";
}
$conn->close();
?>
