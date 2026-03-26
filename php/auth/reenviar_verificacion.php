<?php
session_start();
require_once '../conexion.php';
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);

    if(empty($correo)){
        $_SESSION['error_login'] = "Por favor, ingresa tu correo electrónico para reenviar la verificación.";
        header("Location: ../../login.php");
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    $stmtCheck = $db->prepare("SELECT id_usuario, nombre_completo, verificado FROM usuarios WHERE correo = :correo LIMIT 1");
    $stmtCheck->bindParam(':correo', $correo);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        $usuario = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if($usuario['verificado'] == 1){
            $_SESSION['mensaje_login'] = "Esta cuenta ya está verificada. Puedes iniciar sesión normalmente.";
            header("Location: ../../login.php");
            exit();
        }

        $token = bin2hex(random_bytes(32));
        
        $stmtUpdate = $db->prepare("UPDATE usuarios SET token_verificacion = :token WHERE correo = :correo");
        $stmtUpdate->bindParam(':token', $token);
        $stmtUpdate->bindParam(':correo', $correo);
        $stmtUpdate->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // O tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'TU_USUARIO_SMTP'; // REEMPLAZAR
            $mail->Password = 'TU_PASSWORD_SMTP'; // REEMPLAZAR
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $base_dir = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
            $url = $protocol . "://" . $host . $base_dir . "/verificar_email.php?token=" . $token;

            $mail->setFrom('noreply@hotel.com', 'Hotel Guevarini');
            $mail->addAddress($correo, $usuario['nombre_completo']);
            $mail->Subject = 'Verifica tu cuenta';
            $mail->isHTML(true);
            $mail->Body = "
                Hola {$usuario['nombre_completo']},<br><br>
                Has solicitado un nuevo enlace de verificación para tu cuenta.<br>
                Da clic en el siguiente enlace para verificar tu cuenta y poder iniciar sesión:<br>
                <a href='$url'>Verificar cuenta</a><br><br>
                Si no fuiste tú, ignora este mensaje.
            ";
            $mail->send();
            
            $_SESSION['mensaje_login'] = "Se ha reenviado el enlace de verificación a tu correo.";
        } catch (Exception $e) {
            $_SESSION['error_login'] = "No se pudo reenviar el correo. Error: {$mail->ErrorInfo}";
        }

        header("Location: ../../login.php");
        exit();
    } else {
        $_SESSION['error_login'] = "No se encontró ninguna cuenta con ese correo.";
        header("Location: ../../login.php");
        exit();
    }
} else {
    header("Location: ../../login.php");
    exit();
}
?>
