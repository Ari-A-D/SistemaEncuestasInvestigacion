<?php
// Conectamos con la base de datos
include 'template/conexion.php';

// Obtenemos los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$num_tramite_dni = $_POST['num_tramite_dni'];
$id_encuestador = $_POST['id_encuestador'];
$id_encuesta = $_POST['id_encuesta'];

// Preparamos la declaración SQL y vinculamos los parámetros
$stmt = $conn->prepare("INSERT INTO encuestados (Nombre, Apellido, Edad, DNI, NumTramiteDNI, Id_Encuestador, Id_Encuesta) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssiiiii', $nombre, $apellido, $edad, $dni, $num_tramite_dni, $id_encuestador, $id_encuesta);

// Ejecutamos la declaración SQL
$stmt->execute();

// Obtenemos el ID del encuestado recién insertado
$id_encuestado = $conn->insert_id;
echo "El id del ultimo encuestado: ".$id_encuestado;

// Obtenemos la geolocalización del cuerpo de la solicitud HTTP POST
$lon = floatval($_POST['lon']);
$lat = floatval($_POST['lat']);

// Preparamos la declaración SQL y vinculamos los parámetros
$stmt = $conn->prepare("INSERT INTO georreferenciacion (Latitud, Longitud, Id_Encuestado) VALUES (?, ?, ?)");
$stmt->bind_param('ddi', $lat, $lon, $id_encuestado);

// Ejecutamos la declaración SQL
$stmt->execute();

// Cerramos la conexión con la base de datos
$conn->close();
?>
