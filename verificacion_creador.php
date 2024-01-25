<?php
include 'template/conexion.php';

// Obtener los datos del formulario
$dni = $_POST['dni'];
$password = $_POST['password'];

// Preparar la consulta SQL
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE dni = ? AND activado = 1");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el dni existe en la base de datos y si la activación es igual a 1
if ($result->num_rows > 0) {
 // Obtener el hash de la contraseña de la base de datos
 $row = $result->fetch_assoc();
 $hashed_password = $row['Contrasenia'];

 // Verifica si la contraseña proporcionada por el usuario coincide con el hash almacenado en la base de datos
 if (password_verify($password, $hashed_password)) {
   // Iniciar la sesión y establecer el valor de $_SESSION['dni']
   session_start();
   $_SESSION['dni'] = $dni;
   echo "success";
 } else {
   echo "error";
 }
} else {
 echo "error";
}

// Cerrar la conexión
$conn->close();
?>
