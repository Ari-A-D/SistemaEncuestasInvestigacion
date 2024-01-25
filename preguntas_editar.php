<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Scripts de Bootstrap -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>EDITAR ENCUESTA Y CARGA DE ENCUESTADORES</title> 
    <link rel="stylesheet" href="css/styles.css" type="text/css">
 
</head>
<body>
<!-- Botones del navegarod "terminar formulario", "cargar encuestador" -->
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="ml-auto">
        <button id="back-button" class="btn btn-secondary" type="button" onclick="finalizarCuestionario();">Finalizar Cuestionario</button>
        <button id= "carga-encuestadores" class="btn btn-secondary" type="button">Cargar Encuestadores</button>
      </div>
    </div>
  </div>
</nav>
<!-- Card con el formulario de carga estatica, siempre aparece en pantalla-->
<div class="d-flex flex-wrap">  
<div class="card">
 <div class="card-body">
 <form id="survey-form" class = "input-container" action="guardar_preguntas.php" method="post">
  <div class="card-header">
      <h5><div class="numero"></div></h5>
  </div>
    <div class="form-group">
      <input type="text" class="form-control" id="pregunta" placeholder="Escriba su pregunta">
    </div>
    <input type="hidden" id="id_encuesta" name="id_encuesta" value="<?php echo isset($_GET['id_encuesta']) ? $_GET['id_encuesta'] : ''; ?>">
    <div class="form-group">
      <label for="opciones">Seleccione una opción</label>
      <select class="form-control" id="opciones" onchange="changeImageAndText(this)">
        <option value="1">1. Abierta</option>
        <option value="2">2. Cerrada de opción simple</option>
        <option value="3">3. Cerrada de opción multiple</option>
        <option value="4">4. Semicerrada de opción simple</option>
        <option value="5">5. Semicerrada de opción multiple</option>
        <!--<option value="6">5. Escala</option>-->
      </select>
      <div id="imageAndTextContainer" class="card" style="padding-top: 1cm;">
        <img id="optionImage" src="" alt="Option Image">
        <div class="card-body">
          <p id="optionText" class="card-text"></p>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
      <button type="submit" class="btn btn-primary" id="submit-btn">Guardar pregunta</button>
    </div>
    <div id="message"></div>
  </form>
 </div>
</div>
</div>
<!-- EMERGENTE DE CARGA DE OPCIONES -->
<div class="modal fade" id="modalForm" role="dialog">
<div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Opciones</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form" id="emergent-form">
                    <!-- Los campos de entrada se agregarán dinámicamente aquí -->
                </form>
            </div>
            <div id="modal-message"></div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="submitEmergentForm()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--EMERGENTE PARA CARGA DE ENCUESTADOR-->
<div class="modal fade" id="modalForm-Encuestador" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-sm-down" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFormLabel">Cargar Encuestador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="encuestador-form">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" placeholder="Apellido">
          </div>
          <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" class="form-control" id="edad" placeholder="Edad">
          </div>
          <div class="form-group">
            <label for="dni">DNI</label>
            <input type="number" class="form-control" id="dni" placeholder="DNI">
          </div>
          <div class="form-group">
            <label for="numTramiteDNI">N° de tramite del DNI</label>
            <input type="number" class="form-control" id="numTramiteDNI" placeholder="NumTramiteDNI">
          </div>
          <input type="hidden" id="id_encuesta" name="id_encuesta" value="<?php echo isset($_GET['id_encuesta']) ? $_GET['id_encuesta'] : ''; ?>">
        </form>
        <div id="modal-message-encuestador"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="submit-btn-encuestador">Guardar</button>
      </div>
    </div>
  </div>
</div>
<?php
include 'template/conexion.php';
$id = $_GET['id_encuesta'];
// Ejecutar la consulta
$result = $conn->query("SELECT preguntas.ID AS id_preguntas, preguntas.Detalle AS preguntaDetalle, preguntas.Id_tipo_pregunta AS tipoPregunta, GROUP_CONCAT(CONCAT(respuestas.ID, ':', respuestas.Detalle)) AS respuestasDetalle FROM preguntas LEFT JOIN respuestas ON preguntas.ID = respuestas.Id_Pregunta WHERE preguntas.Id_Encuesta = $id GROUP BY preguntas.Detalle, preguntas.Id_tipo_pregunta");

// Convertir los resultados en un array
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Guardar los datos en una variable de sesión
$_SESSION['data'] = $data;
?>
<div class="card-container">
<div class="card">
  <div class="card-header">
    <h4>MI ENCUESTA</h4>
  </div>
  <div class="table-responsive">
  <div class="card-body">
<table class="table">
  <thead>
    <tr>
      <th><h4>Preguntas</h4></th>
      <th><h4>Tipo de Pregunta</h4></th>
      <th><h4>Respuestas</h4></th>
    </tr>
  </thead>
  <tbody id="responsesData">
    <?php foreach ($_SESSION['data'] as $row): 
        // Dividir respuestasDetalle en un array
        $respuestasDetalle = explode(',', $row['respuestasDetalle']);
  
        foreach ($respuestasDetalle as $index => $respuesta): ?>
<tr class="respuesta-row">
            <?php if ($index === 0): ?>
              <td class="respuesta-cell">
              <h5><?php echo $row['preguntaDetalle']; ?></h5>
              <div class="button-container">
              <button class="edit-button" data-id="<?php echo $row['id_preguntas']; ?>">Editar</button>
              <button class="delete-button-pregunta" data-id="<?php echo $row['id_preguntas']; ?>">Eliminar</button>
              </div>
              </td>
              <td><h6><?php echo $row['tipoPregunta']; ?></h6>
              <div class="button-container">
              <button class="edit-button-tipo" data-id="<?php echo $row['id_preguntas']; ?>">Editar</button>
              </div>
              </td>
            <?php else: ?>
              <td></td>
              <td></td>
            <?php endif; ?>
            <?php
              // Dividir la respuesta en ID y Detalle
              $respuestaParts = explode(':', $respuesta);
              $respuestaID = isset($respuestaParts[0]) ? $respuestaParts[0] : null;
              $respuestaDetalle = isset($respuestaParts[1]) ? $respuestaParts[1] : null;
            ?>
            <td>
            
              <?php echo $respuestaDetalle; ?>
              <div class="button-container">
              <button class="edit-button-opcion" data-id="<?php echo $respuestaID; ?>">Editar</button>
              <button class="delete-button-opcion" data-id="<?php echo $respuestaID; ?>">Eliminar</button>
            </div>
            </td>
          </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
</div>
<?php
include 'template/conexion.php';

// Ejecutar la consulta
$result = $conn->query("SELECT * FROM encuestadores WHERE Id_Encuesta = $id");

// Convertir los resultados en un array
$dataEncuestadores = [];
while ($row = $result->fetch_assoc()) {
    $dataEncuestadores[] = $row;
}

// Guardar los datos en una variable de sesión
$_SESSION['dataEncuestadores'] = $dataEncuestadores;
?>
<div class="card second-card">
  <div class="card-header">
    <h4>MIS ENCUESTADORES</h4>
  </div>
  <div class="table-responsive">
  <div class="card-body">
<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>NumTramiteDNI</th>
        <th>Actividad</th>
    </tr>
    <?php foreach ($_SESSION['dataEncuestadores'] as $row): ?>
    <tr>
        <td><a href="#" class="edit-Nombre" data-id="<?php echo $row['ID']; ?>"><?php echo $row['Nombre']; ?></a></td>       
        <td><a href="#" class="edit-Apellido" data-id="<?php echo $row['ID']; ?>"><?php echo $row['Apellido']; ?></a></td>     
        <td><a href="#" class="edit-DNI" data-id="<?php echo $row['ID']; ?>"><?php echo $row['DNI'];  ?></a></td>  
        <td><a href="#" class="edit-NumTramiteDNI" data-id="<?php echo $row['ID']; ?>"><?php echo $row['NumTramiteDNI']; ?></a></td>  
        <td><button class="delete-button-encuestador" data-id="<?php echo $row['ID']; ?>">Eliminar</button></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</div>
    </div>
    </div>
    <script src="js/preguntas_editar.js"></script>

</body>
</html>

