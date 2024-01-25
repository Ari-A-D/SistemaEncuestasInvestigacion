<?php
include 'template/conexion.php';
// Obtener los datos del formulario
$dni = $_POST['dni'];

// Preparar la consulta SQL
$sql = "SELECT ID, Id_Encuesta FROM encuestadores WHERE DNI = '$dni'";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si el dni y la password existen en la base de datos
if ($result->num_rows > 0) {
  // Iniciar la sesión y establecer los valores de $_SESSION['id'] y $_SESSION['id_encuesta']
  session_start();
  $row = $result->fetch_assoc();
  $_SESSION['id'] = $row['ID'];
  $_SESSION['id_encuesta'] = $row['Id_Encuesta'];
  $_SESSION['dni'] = $dni;
  echo "success";
} else {
  echo "error";
}

// Cerrar la conexión
$conn->close();

?>