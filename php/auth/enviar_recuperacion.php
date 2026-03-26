<?php
session_start();
require_once '../conexion.php';
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);

    if (empty($correo)) {
        $_SESSION['error_recuperar'] = "Por favor, ingresa tu correo.";
        header("Location: ../../views/recuperar.php");
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    $stmtCheck = $db->prepare("SELECT id_usuario, nombre_completo FROM usuarios WHERE correo = :correo");
    $stmtCheck->bindParam(':correo', $correo);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        $usuario = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        $nombre = $usuario['nombre_completo'];

        $token = bin2hex(random_bytes(32));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmtUpdate = $db->prepare("UPDATE usuarios SET token_recuperacion = :token, expiracion_token_recuperacion = :expiracion WHERE correo = :correo");
        $stmtUpdate->bindParam(':token', $token);
        $stmtUpdate->bindParam(':expiracion', $expiracion);
        $stmtUpdate->bindParam(':correo', $correo);
        $stmtUpdate->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '7e5afe727f22b9';
            $mail->Password = '04c817ebd1c7b3';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            $mail->setFrom('noreply@hotel.com', 'Hotel Guevarini');
            $mail->addAddress($correo, $nombre);
            $mail->Subject = 'Recuperacion de Contrasena';
            $mail->isHTML(true);
            
            // Usando directorio dinámico para que no falle el link si se cambia de carpeta
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            // dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) = raiz del proyecto
            $base_dir = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
            $url = $protocol . "://" . $host . $base_dir . "/views/reset_password.php?token=" . $token;

            $mail->Body = "
                Hola $nombre,<br><br>
                Has solicitado restablecer tu contraseña.<br>
                Da clic en el siguiente enlace para crear una nueva:<br>
                <a href='$url'>Restablecer Contraseña</a><br><br>
                Si no fuiste tú, ignora este mensaje. El enlace expirará en 1 hora.
            ";
            $mail->send();
            $_SESSION['mensaje_recuperar'] = "Se ha enviado un enlace de recuperación a tu correo.";
        } catch (Exception $e) {
            $_SESSION['error_recuperar'] = "No se pudo enviar el correo de recuperación. Error: {$mail->ErrorInfo}";
        }
    } else {
        // Por seguridad, damos un mensaje genérico
        $_SESSION['mensaje_recuperar'] = "Si el correo existe en nuestro sistema, se ha enviado un enlace de recuperación.";
    }

    header("Location: ../../views/recuperar.php");
    exit();
} else {
    header("Location: ../../views/recuperar.php");
    exit();
}
?>
