<?php
include 'template/conexion.php';

// Obtener los datos del formulario
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];
$email = $_POST['email'];

// Comprobar si las contraseñas son iguales
if ($password !== $confirm_password) {
 echo "Las contraseñas no coinciden";
 exit();
}

// Comprobar si el dni ya existe
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE dni = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
 echo "El dni ya existe";
 exit();
}

// Comprobar si la password ya existe
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE contrasenia = ?");
$stmt->bind_param("s", $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
 echo "La password ya existe";
 exit();
}

// Crear un hash de la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Generar un código de activación
$activation_code = md5(uniqid(rand(), true));

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO usuarios (dni, contrasenia, NombreUsuario, email, codigo_activacion) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $dni, $hashed_password, $nombre, $email, $activation_code);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Ejecutar la consulta
if ($stmt->execute() === TRUE) {
   // Enviar un correo electrónico de confirmación 
   require 'vendor/autoload.php';
   $mail = new PHPMailer(true);
   try {
    // Configuración del servidor
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'emailservidor';
    $mail->Password = 'contraseniavinculantedesdeemailserver';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
  
    // Recipientes
    $mail->setFrom('arianaaracelidiaz@gmail.com', 'Mailer');
    $mail->addAddress($email, $nombre);
    $mail->addReplyTo('arianaaracelidiaz@gmail.com', 'Information');
  
    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Por favor, confirma tu cuenta';
    $mail->Body = "Haz clic en el enlace de abajo para activar tu cuenta:\n\n";
    $mail->Body .= "http://localhost:6969/activacion.php?code=$activation_code";
  
    $mail->send();
   } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
   echo 'success';
  } else {
   echo "error";
  }
  
?>
