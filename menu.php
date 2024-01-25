<?php
session_start();
if (isset($_SESSION['dni'])) {
    echo "<div style='color: white; background-color: black;'>Bienvenido, usuario: " . $_SESSION['dni'] . "</div>";
    $dniSesion=$_SESSION['dni'];
} else {
  // Si el usuario no ha iniciado sesión, redirígelo a la página de inicio de sesión
  header("Location: acceso_creador.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <script src="js/menu.js"></script>
    <title>MENU</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="d-flex flex-column flex-lg-row justify-content-between w-100">
    <form class="d-flex mb-2 mb-lg-0" role="search">
      <div class="input-group">
        <input id="search" autocomplete="off" class="form-control" type="text" placeholder="Buscar encuesta" aria-label="Search">
      </div>
    </form>
      <div class="d-flex">
        <button id="logout-button" class="btn btn-secondary me-2" type="button">Cerrar sesión</button>  
        <button id="create-button" class="btn btn-secondary" type="button" data-toggle="modal" data-target="#myModal">Crear encuesta</button>
      </div>
    </div>
  </div>
</nav>

<body>
<!--LISTA DE ENCUESTAS-->
<!-- ... -->
<div class="container">
<div id="mensaje"></div> <!-- Aquí es donde se mostrará el mensaje de confirmación -->
        <h2>MIS ENCUESTAS</h2>
        <div class="table-responsive">
        <table class="table" id="tablaEncuestas">
            <thead>
                <tr>
                    <th>ID Encuesta</th>
                    <th>Nombre encuesta</th>
                    <th>Estado de la encuesta</th>
                    <th>Configuraciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                include "template/conexion.php";

                // Prepara y ejecuta la primera consulta para obtener el ID del usuario
                $consulta_id = $conn->prepare("SELECT ID FROM usuarios WHERE dni = ?");
                $consulta_id->bind_param('s', $dniSesion);
                $consulta_id->execute();
                $resultado = $consulta_id->get_result();
                $idUsuario = $resultado->fetch_assoc()["ID"];

                // Prepara y ejecuta la segunda consulta usando el ID del usuario obtenido
                $sql = $conn->prepare("SELECT ID, Nombre FROM encuesta WHERE id_usuario = ?");
                $sql->bind_param('i', $idUsuario);
                $sql->execute();
                $result = $sql->get_result();
                // Comprueba si hay resultados
                if ($result->num_rows > 0) {
                    // Si hay resultados, itera sobre ellos y genera el HTML
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>";
                        echo "<td>" . $row["Nombre"] . "</td>";
                        echo "<td>";
                        echo "<button class='activar btn btn-success mr-3' data-id='" . $row['ID'] . "'>Activar</button>";
                        echo "<button class='desactivar btn btn-warning' style='display: none;'>Desactivar</button>";
                        echo "<br><br>";
                        echo "<div class='qrcode-container' style='display: flex; flex-direction: column; justify-content: center; align-items: center; border-collapse: collapse;'>";
                        echo "<div id='qrcode-" . $row['ID'] . "' style='margin: auto; height: auto;'></div>";
                        echo "<a class='url-link' style='display: none;'></a>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='rose_karanese.php?id_encuesta=" . $row["ID"] . "' class='btn btn-primary mr-3'>VER</a>";
                        echo "<a href='rose_utopia.php?id_encuesta=" . $row["ID"] . "' class='btn btn-info mr-3'>Editar</a>";
                        echo "<a href='#' class='btn btn-danger' onclick=\"eliminarEncuesta(" . $row["ID"] . "); return false;\">Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr colspan='3'>Todavia no tiene encuestas creadas</tr>";
                }
                // Cierra la conexión
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
  </div>
<!-- EMERGENTE PARA CREAR NUEVAS ENCUESTAS-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Crear encuesta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form id="survey-form" action="nombre_encuesta.php" method="post">
        <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
             <label for="nombre">Nombre de la encuesta</label>
             <input id="nombre" name="nombre" type="text" placeholder="Escriba el nombre de su encuesta">

             <label for="descripcion">Descripcion</label>
             <input id="descripcion" name="descripcion" type="text" placeholder="De una breve descripcion">

             <label for="objetivo">Objetivo</label>
             <input id="objetivo" name="objetivo" type="text" placeholder="Escriba los objetivos"">

             <label for="fecha">Fecha</label>
             <input id="fecha" name="fecha" type="text" value="<?php echo date('Y-m-d'); ?>">

             <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $idUsuario; ?>">
            <!-- Div para mostrar los mensajes -->
            <div id="message"></div>
             
            <div class="row h-100 justify-content-center align-items-center">
             <button id="save-button" type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </div>
            </div>
        </form>
    </div>
  </div>
</div>
</body>
</html>