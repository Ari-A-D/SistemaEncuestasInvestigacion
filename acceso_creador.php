<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <script src="js/acceso_creador.js"></script>
  <title>Login-Creador</title>
</head>
<body>
<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-sm-12 col-md-6">
        <div class="card">
        <div class="card-header d-flex justify-content-center mt-3">
                <?php include 'template/header.php'?>
        </div>
          <div class="card-body">
            <h5 class="card-title">Iniciar sesión</h5>
            <form id="login-form" action="verificacion_login.php" method="post">
            <div class="form-group">
              <label for="dni">DNI</label>
              <input type="text" class="form-control" id="dni" name="dni" pattern="\d+" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
            </div>
              <div class="form-group">
              <div class="input-group">
              <input id="password" class="form-control" placeholder="Contraseña" name="password" type="password" onkeypress="return checkInput(event)" required>
              <div class="input-group-append" id="togglePassword">
                <span class="input-group-text">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
              </div>
              </div>
              <div style="position: relative;">
                <a href="recuperar_contrasenia_formulario.php" class="btn btn-link" style="position: absolute; top: 7px; right: 0px;">¿Olvidaste tu contraseña?</a>
              </div>
              <br><br>

            </div>
            <div class="row justify-content-center mt-2">
              <div id="inputError" class="alert alert-warning" role="alert" style="display: none;">
                Caracteres no permitidos. Solo se permiten letras, números y los caracteres #,*,@
              </div>
              </div>
              <div class="row h-100 justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary mr-1">Iniciar sesión</button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="location.href='registro_creador.php';">Registrarse</button>
            <div id="message"></div>
            </div>
            <div class="row justify-content-center mt-3">
            <button type="button" class="btn btn-secondary" onclick="location.href='acceso_encuestador.php';">Acceso Encuestador</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
<script src="js/maria.js"></script>
</body>
</html>
