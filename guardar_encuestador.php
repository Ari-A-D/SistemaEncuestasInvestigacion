<?php
include 'template/conexion.php';

// Obtener los datos del POST
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$numTramiteDNI = $_POST['numTramiteDNI'];
$id_encuesta = $_POST['id_encuesta'];

// Preparar la consulta SQL
$sql = "INSERT INTO encuestadores (Nombre, Apellido, Edad, DNI, NumTramiteDNI, Id_Encuesta) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Vincular los parámetros a la consulta
$stmt->bind_param("ssiiis", $nombre, $apellido, $edad, $dni, $numTramiteDNI, $id_encuesta);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
