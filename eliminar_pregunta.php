<?php
include 'template/conexion.php';

if (isset($_POST['id_preguntas'])) {
        
    $preguntaID = $_POST['id_preguntas'];
    // Preparar la sentencia SQL
    $stmt = $conn->prepare("DELETE FROM respuestas WHERE Id_Pregunta = ?");

    // Vincular los parámetros
    $stmt->bind_param('i', $preguntaID);

    // Ejecutar la sentencia
    $stmt->execute();

    // Preparar la sentencia SQL
    $stmt = $conn->prepare("DELETE FROM preguntas WHERE ID = ?");

    // Vincular los parámetros
    $stmt->bind_param('i', $preguntaID);

    // Ejecutar la sentencia
    $stmt->execute();
    echo "Pregunta eliminada con exito";

}else{
    echo "Error al eliminar la pregunta";
}

?>
