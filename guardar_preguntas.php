<?php
include 'template/conexion.php';
$id_encuesta = $_POST['id_encuesta'];
$opciones = $_POST['opciones'];
$pregunta = $_POST['pregunta'];
//cantidad de opciones del emergente
$cantidad_opciones = $_POST['cantidad_opciones'];
// Prepara la consulta SQL
$sql = "INSERT INTO preguntas (Detalle, CantidadOpciones, Id_Encuesta, Id_tipo_pregunta) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siii", $pregunta, $cantidad_opciones, $id_encuesta, $opciones);

// Ejecuta la consulta SQL
if ($stmt->execute()) {
  // Obtener la ID generada
  $id_pregunta = $conn->insert_id;
  // Verificar si $opciones es igual a 0
  if ($opciones == 1) {
    // Si es igual a 0, asignar 'Abierta' a $opcion y ejecutar la consulta SQL una sola vez
    $opcion = 'Abierta';
    $valor = 0;
    $sql = "INSERT INTO respuestas (Detalle, Valor, Id_Pregunta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $opcion, $valor, $id_pregunta);
    if (!$stmt->execute()) {
      echo "Error: " . $stmt->error;
    }
    $stmt->close();
  }
  // Enviar la ID al cliente
  echo json_encode(['status' => 'success', 'id_pregunta' => $id_pregunta]);
} else {
  echo "error";
}

$conn->close();

?>