<?php
include 'template/conexion.php';

// Obtener el token de la URL
$token = $_GET['token'];

// Verificar si el token es válido
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE codigo_activacion = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo "Lo siento, el token proporcionado no es válido o ha expirado.";
  exit();
}

// El token es válido, mostrar el formulario para restablecer la contraseña
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cambiar contraseña</title>
</head>
<body>
	<h1>Cambiar contraseña</h1>
	<form action="cambiar_contrasenia_proceso.php" method="post">
         <!-- Agrega un campo oculto para el token -->
        <input type="hidden" name="token" value="<?php echo $token; ?>">
		<label for="password">Nueva contraseña:</label>
		<input type="password" id="password" name="password" required>
		<button type="submit">Restablecer contraseña</button>
	</form>
</body>
</html>
