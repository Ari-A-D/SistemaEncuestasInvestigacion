<?php
include 'template/conexion.php';

// Verificar si el correo electrónico existe en la base de datos
$email = $_POST['email'];
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
   echo "No existe ninguna cuenta con ese correo electrónico.";
   exit();
}

// Generar un token único
$token = bin2hex(random_bytes(50));

// Guardar el token en la base de datos
$stmt = $conn->prepare("UPDATE usuarios SET codigo_activacion = ? WHERE email = ?");
$stmt->bind_param("ss", $token, $email);
$stmt->execute();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if ($stmt->execute() === TRUE) {
   $razon = "Reestablecer la contrasenia";
// Enviar un correo electrónico al usuario con el enlace de restablecimiento de contraseña
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try {
   // Configuración del servidor
   $mail->SMTPDebug = 0;
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'arianaaracelidiaz@gmail.com';
   $mail->Password = 'ggnsmsbrvhkqgild';
   $mail->SMTPSecure = 'tls';
   $mail->Port = 587;

   // Remitentes
   $mail->setFrom('arianaaracelidiaz@gmail.com', 'Mailer');
   $mail->addAddress($email, $razon);
   $mail->addReplyTo('arianaaracelidiaz@gmail.com', 'Information');

   // Contenido
   $mail->isHTML(true);
   $mail->Subject = 'Restablece tu contraseña';
   $mail->Body = "Haz clic en el enlace de abajo para restablecer tu contraseña:\n\n";
   $mail->Body .= "http://localhost:6969/cambiar_contrasenia.php?token=$token";

   $mail->send();
} catch (Exception $e) {
   echo "El mensaje no pudo ser enviado. Error del correo: {$mail->ErrorInfo}";
}
echo 'success';
} else {
   echo "error";
  }
?>
