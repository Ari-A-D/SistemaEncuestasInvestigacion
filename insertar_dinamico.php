<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'template/conexion.php';
    $respuestasTipo2y3 = array();
    $respuestasTipo4y5 = array();
    $respuestasAbiertas = array();
    $id_encuestado = $_POST['id_encuestado_hidden'];

    //var_dump($_POST);
    foreach ($_POST as $key => $valor) {
        if (strpos($key, 'customRadio') === 0) {
            $customRadio = $valor;
            $respuestasTipo2y3[] = array(
                'id_respuesta' => $customRadio,
            );
            }elseif (strpos($key, 'textInput4') === 0) {
                $customRadioText = $valor;
            if (isset($customRadio) && $customRadio !== null){
                    $respuestasTipo4y5[] = array(
                    'id_respuesta' => $customRadio,
                    'detalle_respuesta' => $customRadioText,
                    );
            }
        } 
        if (strpos($key, 'inlineCheckbox') === 0) {
            foreach ($valor as $checkboxValue) {
                $respuestasTipo2y3[] = array(
                    'id_respuesta' => $checkboxValue,
                );
            }
            } if (strpos($key, 'textInput5') === 0) {
                $checkboxValueText = $valor;
                if (isset($checkboxValue) && $checkboxValue !== null){
                    $respuestasTipo4y5[] = array(
                    'id_respuesta' => $checkboxValue,
                    'detalle_respuesta' => $checkboxValueText,
                    );
                }
        }
        if (strpos($key, 'textInputAbierta') === 0) {
            $textInputIndex = str_replace('textInputAbierta', '', $key);
            if (isset($textInputIndex) && $textInputIndex  !== null){
                $hiddenInputValue = $_POST['hiddenInput' . $textInputIndex];
                $respuestasAbiertas[] = array(
                    'id_respuesta' => $hiddenInputValue,
                    'detalle_respuesta' => $valor,  // Modificado aquí
                );
            }
        }
        
        
    }

    // Elimina duplicados en $respuestasTipo4y5
    $respuestasTipo4y5 = super_unique($respuestasTipo4y5, 'id_respuesta');
    // Crea un array con todas las id_respuesta de $respuestasTipo4y5
    $idsTipo4y5 = array_column($respuestasTipo4y5, 'id_respuesta');
    // Filtra $respuestasTipo2y3 para eliminar las entradas cuya id_respuesta exista en $idsTipo4y5
    $respuestasTipo2y3 = array_filter($respuestasTipo2y3, function ($respuesta) use ($idsTipo4y5) {
        return !in_array($respuesta['id_respuesta'], $idsTipo4y5);
    });
    
    // Reindexa las claves del array después de filtrarlo
    $respuestasTipo2y3 = array_values($respuestasTipo2y3);
    $jsonRespuestas2y3 = json_encode($respuestasTipo2y3);
    $jsonRespuestas4y5 = json_encode($respuestasTipo4y5);
    $jsonRespuestasAbiertas = json_encode($respuestasAbiertas);

$idEncuestado = ($id_encuestado+1);
// Decodifica el JSON
$respuestas2y3 = json_decode($jsonRespuestas2y3, true);
$respuestas4y5 = json_decode($jsonRespuestas4y5, true);
$respuestasAbiertas = json_decode($jsonRespuestasAbiertas, true);

// Itera sobre los datos y los inserta en la base de datos

foreach ($respuestas2y3 as $respuesta) {
    $id_respuesta = $respuesta['id_respuesta'];
    $fecha = date('Y-m-d');  // Obtiene la fecha actual

    // Prepara la consulta SQL
    $query = "INSERT INTO encuestados_respuestas (Fecha, Id_Encuestado, Id_Respuesta, Detalle) VALUES (?, ?, ?, '')";

    // Ejecuta la consulta SQL
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $fecha, $idEncuestado, $id_respuesta);
    $stmt->execute();
}

// Itera sobre los datos y los inserta en la base de datos
foreach ($respuestas4y5 as $respuesta) {
    $id_respuesta = $respuesta['id_respuesta'];
    $detalle_respuesta = $respuesta['detalle_respuesta'];
    $fecha = date('Y-m-d');  // Obtiene la fecha actual

    // Prepara la consulta SQL
    $query = "INSERT INTO encuestados_respuestas (Fecha, Id_Encuestado, Id_Respuesta, Detalle) VALUES (?, ?, ?, ?)";

    // Ejecuta la consulta SQL
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siis", $fecha, $idEncuestado, $id_respuesta, $detalle_respuesta);
    $stmt->execute();
}
// Itera sobre los datos y los inserta en la base de datos
foreach ($respuestasAbiertas as $respuesta) {
    $id_respuesta = $respuesta['id_respuesta'];
    $detalle_respuesta = $respuesta['detalle_respuesta'];
    $fecha = date('Y-m-d');  // Obtiene la fecha actual

    // Prepara la consulta SQL
    $query = "INSERT INTO encuestados_respuestas (Fecha, Id_Encuestado, Id_Respuesta, Detalle) VALUES (?, ?, ?, ?)";

    // Ejecuta la consulta SQL
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siis", $fecha, $idEncuestado, $id_respuesta, $detalle_respuesta);
    $stmt->execute();
}
$mensaje = 'Encuesta guardada';
    // Agrega un bloque de script JavaScript para mostrar la ventana emergente
    echo '<script>';
    echo 'var mensaje = "' . $mensaje . '";';
    echo 'alert(mensaje);';
    
    // Cierra la ventana emergente después de 3 segundos (3000 milisegundos)
    echo 'setTimeout(function() { window.close(); }, 2000);';
    
    echo '</script>';
}
//BORRA LAS ID IGUALES DENTRO DEL MISMO ARRAY
function super_unique($array, $key) {
    $temp_array = array();

    foreach ($array as &$v) {
        if (!isset($temp_array[$v[$key]])) {
            $temp_array[$v[$key]] =& $v;
        }
    }
    $array = array_values($temp_array);
    return $array;
}
    ?>