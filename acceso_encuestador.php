<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <script src="js/acceso_encuestador.js"></script>
  <title>Login-encuestador</title>
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
            <form id="login-form" action="verificacion_encuestador.php" method="post">
              <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
              </div>
              <div class="row h-100 justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <div id="message"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
