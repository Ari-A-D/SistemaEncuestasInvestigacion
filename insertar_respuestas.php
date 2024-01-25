<?php
// Incluir la conexión a la base de datos
include 'template/conexion.php';

// Recoger los datos del formulario ESTATITCO
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$numTramiteDNI = $_POST['numTramiteDNI'];
$idEncuestador = $_POST['idEncuestador'];
$idEncuesta = $_POST['idEncuesta'];

// Insertar los datos en la tabla encuestados
$sql = "INSERT INTO encuestados (Nombre, Apellido, Edad, DNI, NumTramiteDNI, Id_Encuestador, Id_Encuesta) VALUES ('$nombre', '$apellido', '$edad', '$dni', '$numTramiteDNI', '$idEncuestador', '$idEncuesta')";
if ($conn->query($sql) === TRUE) {
    // Recuperar el ID generado automáticamente
    $idEncuestado = $conn->insert_id;
    echo "Nuevo registro creado con éxito. ID del encuestado: $idEncuestado";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// INSERTA GEORREFERENCIAS
// Recoger los datos del formulario
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
$id_encuestado = $_POST['id_encuestado'];
// Preparar la consulta SQL
$sql = "INSERT INTO georreferenciacion (Latitud, Longitud, Id_Encuestado) VALUES (?, ?, ?)";
// Preparar la declaración
$stmt = $conn->prepare($sql);
// Vincular los parámetros
$stmt->bind_param("ddi", $latitud, $longitud, $id_encuestado);
// Ejecutar la declaración
$stmt->execute();
// Cerrar la declaración
$stmt->close();
// Cerrar la conexión
$conn->close();
// Recoger los datos de las respuestas
$respuestas = $_POST['dynamicForm'];

// Insertar los datos de las respuestas en la tabla encuestados_respuestas
foreach ($respuestas as $key => $value) {
    if (strpos($key, 'textInput') !== false) {
        $idRespuesta = explode('textInput', $key)[1];
        $detalle = $value;
        $sql = "INSERT INTO encuestados_respuestas (Fecha, Id_Encuestado, Id_Respuesta, Detalle) VALUES (CURDATE(), '$idEncuestador', '$idRespuesta', '$detalle')";
        if ($conn->query($sql) === TRUE) {
            echo "Nuevo registro de respuesta creado con éxito";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
