<?php
require_once 'tu-ruta/htdocs/CRUD-HOTEL-GUEVARINI-Publico/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);
try {
    // Aqui va tu configuracion de SMTP
    $mail->isSMTP();
    $mail->Host = 'tu-host';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu-usuario';
    $mail->Password = 'tu-contraseña';
    $mail->SMTPSecure = 'tu-seguridad';
    $mail->Port = 'tu-puerto';
    $mail->SMTPDebug = 2;

    // Destinatarios
    $mail->setFrom('noreply@hotel.com', 'Hotel Test');
    $mail->addAddress('test@example.com', 'Test User');
    $mail->Subject = 'Test Verificacion';
    $mail->isHTML(true);
    $mail->Body = "Hola mundo";
    $mail->send();
    echo "EXITO: El correo se envio correctamente a Mailtrap.\n";
}
catch (Exception $e) {
    echo "ERROR: {$mail->ErrorInfo}\n";
    echo $e->getMessage();
}
