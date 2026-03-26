<?php
require_once 'c:/apache/htdocs/PROYECTO-FINAL/CRUD-HOTEL-COPIA/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '7e5afe727f22b9';
    $mail->Password = '04c817ebd1c7b3';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;
    $mail->SMTPDebug = 2; // Habilitar output de debug

    $mail->setFrom('noreply@hotel.com', 'Hotel Test');
    $mail->addAddress('test@example.com', 'Test User');
    $mail->Subject = 'Test Verificacion';
    $mail->isHTML(true);
    $mail->Body = "Hola mundo";
    $mail->send();
    echo "EXITO: El correo se envio correctamente a Mailtrap.\n";
} catch (Exception $e) {
    echo "ERROR: {$mail->ErrorInfo}\n";
    echo $e->getMessage();
}
