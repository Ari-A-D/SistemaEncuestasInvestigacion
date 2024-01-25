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
  <script src="js/alta_creador.js"></script>
  <title>Registro</title>
</head>
<body>
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Registro</h5>
            <form id="register-form" action="alta_creador.php" method="post">
                <div class="form-group">
                  <label for="dni">Número de DNI</label>
                  <input type="number" class="form-control" id="dni" name="dni" pattern="\d+" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre del Usuario</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                  <label for="email">Correo Electrónico</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
              <div class="form-group">
                      <label for="password">Contraseña</label>
                      <div class="input-group">
                    <input id="password" class="form-control" placeholder="Contraseña" name="password" type="password" onkeypress="return checkInput(event)" required>
                    <div class="input-group-append" id="togglePassword">
                      <span class="input-group-text">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </span>
                    </div>
                    </div>
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirmar Contraseña</label>
                <div class="input-group">
                  <input id="confirm-password" class="form-control" placeholder="Confirmar Contraseña" name="confirm-password" type="password" onkeypress="return checkInput(event)" required>
                  <div class="input-group-append" id="toggleConfirmPassword">
                    <span class="input-group-text">
                      <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                  </div>
                  </div>
              </div>
              <div class="row justify-content-center mt-2">
              <div id="inputError" class="alert alert-warning" role="alert" style="display: none;">
                Caracteres no permitidos. Solo se permiten letras, números y los caracteres #,*,@
              </div>

              <div id="passwordAlert" class="alert alert-danger" role="alert" style="display: none;">
                Las contraseñas no coinciden
              </div>

              </div>
              <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>
            <div id="message"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/maria.js"></script>

</body>
</html>
