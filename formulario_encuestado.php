<?php
session_start();
if (isset($_SESSION['dni'])) {
   echo "<div style='color: white; background-color: black;'>Bienvenido, usuario: " . $_SESSION['dni'] . "</div>";
   if (isset($_SESSION['id']) && isset($_SESSION['id_encuesta'])) {
       $idEncuestador=$_SESSION['id'];
       $idEncuesta=$_SESSION['id_encuesta'];
   } else {
       echo "Error: Las claves 'id' y/o 'id_encuesta' no están definidas en el array de la sesión.";
   }
} else {
 // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión
 header("Location: acceso_encuestador.php");
 exit();
}

?>
<?php include_once "insertar_dinamico.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/encuesta_estatica.css" type="text/css">
    <link rel="stylesheet" href="css/styles_encuestas.css" type="text/css">
    <script src="js/encuestados.js"></script>
    <title>formulario encuestado</title>
</head>
<!--CUERPO DEL HTML-->
<body>
<?php
//CONSULTA PHP PARA TRAER EL NOMBRE DE LA ENCUESTA
include "template/conexion.php"; 
$sql = "SELECT Nombre, Descripcion FROM encuesta WHERE ID = $idEncuesta";
$result = $conn->query($sql);
// Verificar si la consulta fue exitosa
if ($result->num_rows > 0) {
    // Obtener el nombre de la encuesta
    $row = $result->fetch_assoc();
    $nombre_encuesta = $row['Nombre'];
    $descripcion = $row['Descripcion'];
} else {
    echo "Encuesta";
}
$conn->close();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <h4 style="font-size: 2vw;"><?php echo $nombre_encuesta; ?></h4>
    <p style="font-size: 1vw;"><?php echo $descripcion; ?></p>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button class="btn btn-outline-success me-2" type="button" onclick="location.href='destructor_sesion_encuestador.php';" id="logoutButton">Cerrar sesión</button>
      </li>
    </ul>
  </div>
</nav>
<div class="card">
  <h5 class="card-header">Datos basicos del encuestado</h5>
  <div class="card-body">
<form id="staticForm" action="insertar_encuestado.php" method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre"><br>
    <label>Apellido:</label><br>
    <input type="text" name="apellido"><br>
    <label>Edad:</label><br>
    <input type="number" name="edad"><br>
    <label>DNI:</label><br>
    <input type="number" name="dni"><br>
    <label>Número de Trámite DNI:</label><br>
    <input type="number" name="num_tramite_dni"><br>
    <input type="hidden" name="id_encuestador" value="<?php echo $idEncuestador; ?>">
    <input type="hidden" name="id_encuesta" value="<?php echo $idEncuesta; ?>">
    <input type="hidden" id="lat" name="lat">
    <input type="hidden" id="lon" name="lon">
    <div class="card-footer text-center">
    <button type="button" id="submitButtonStatic" onclick="showAutoconstructor();">Enviar</button>
    </div>
</form>
</div>
</div>
<script src="js/georeferencias.js"></script>
<div id="successMessage" style="display:none; background-color: lightblue;">Datos del encuestado guardados correctamente</div>
<!-- Este es tu contenedor al que se agregará el formulario dynamicForm-->
<div id="autoconstructor" style="margin-left: 1cm; display: none;"></div>
<!--PHP PARA LA CONSULTA DEL AUTOCONSTRUCTOR-->
<script>
<?php
    $id = $idEncuesta;
    include 'template/conexion.php';
    // Obtiene la última ID de la tabla de encuestados
    $query = "SELECT ID FROM encuestados ORDER BY ID DESC LIMIT 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $last_id = $row['ID'];

    $result = $conn->query("SELECT preguntas.Detalle AS preguntaDetalle, preguntas.Id_tipo_pregunta AS tipoPregunta, GROUP_CONCAT(CONCAT(respuestas.ID, ':', respuestas.Detalle)) AS respuestasDetalle FROM preguntas LEFT JOIN respuestas ON preguntas.ID = respuestas.Id_Pregunta WHERE preguntas.Id_Encuesta = $id GROUP BY preguntas.Detalle, preguntas.Id_tipo_pregunta");
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo 'var data = ' . json_encode($data) . ';';
    echo 'var last_id = ' . $last_id . ';';
?>
</script>
<script src="js/autoconstructor.js"></script>
</body>
</html>