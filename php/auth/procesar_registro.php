<?php
session_start();
require_once '../conexion.php';
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = trim($_POST['nombre_completo']);
    $correo = trim($_POST['correo']);
    $password_raw = $_POST['password'];
    $rol = 2; // Cliente de forma predeterminada para registros públicos

    if(empty($nombre) || empty($correo) || empty($password_raw)){
        $_SESSION['error_registro'] = "Todos los campos son obligatorios.";
        header("Location: ../../views/registro.php");
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    // Validar que el correo no exista
    $stmtCheck = $db->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo");
    $stmtCheck->bindParam(':correo', $correo);
    $stmtCheck->execute();
    
    if($stmtCheck->rowCount() > 0){
        $_SESSION['error_registro'] = "El correo ingresado ya está registrado. Intenta iniciar sesión o recuperar tu contraseña.";
        header("Location: ../../views/registro.php");
        exit();
    }

    $token = bin2hex(random_bytes(32));

    $query = "INSERT INTO usuarios (nombre_completo, correo, password, id_rol, verificado, token_verificacion) 
              VALUES (:nombre, :correo, :password, :rol, 0, :token)";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password_raw);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':token', $token);

    if($stmt->execute()){
        $id_nuevo_usuario = $db->lastInsertId();
        
        // Crear su registro en clientes
        $stmtCliente = $db->prepare("INSERT INTO clientes (id_usuario, nombre_completo, telefono, estado) VALUES (:id_usuario, :nombre, '000-0000', 'Activo')");
        $stmtCliente->bindParam(':id_usuario', $id_nuevo_usuario);
        $stmtCliente->bindParam(':nombre', $nombre);
        $stmtCliente->execute();

        // Enviar email de verificación
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '7e5afe727f22b9';
            $mail->Password = '04c817ebd1c7b3';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Obtener el protocolo y servidor actuales dinámicamente
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $base_dir = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
            $url = $protocol . "://" . $host . $base_dir . "/verificar_email.php?token=" . $token;

            $mail->setFrom('noreply@hotel.com', 'Hotel Guevarini');
            $mail->addAddress($correo, $nombre);
            $mail->Subject = 'Verifica tu cuenta';
            $mail->isHTML(true);
            $mail->Body = "
                Hola $nombre,<br><br>
                Te has registrado exitosamente.<br>
                Da clic para verificar tu cuenta y poder iniciar sesión:<br>
                <a href='$url'>Verificar cuenta</a><br><br>
                Si no solicitaste crear esta cuenta, ignora este mensaje.
            ";
            $mail->send();
            
            $_SESSION['mensaje_registro'] = "¡Cuenta creada exitosamente! Por favor, revisa tu correo electrónico para verificarla antes de iniciar sesión.";
            header("Location: ../../views/registro.php");
            exit();
            
        } catch (Exception $e) {
            $_SESSION['error_registro'] = "Cuenta creada, pero ocurrió un problema al enviar el correo de verificación. Error: {$mail->ErrorInfo}";
            header("Location: ../../views/registro.php");
            exit();
        }
    } else {
        $_SESSION['error_registro'] = "Ocurrió un error al registrar tu cuenta. Intenta más tarde.";
        header("Location: ../../views/registro.php");
        exit();
    }

} else {
    header("Location: ../../views/login.php");
    exit();
}
?>
