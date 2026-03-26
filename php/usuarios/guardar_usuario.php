<?php
session_start();
require_once '../conexion.php';
require_once '../../vendor/autoload.php'; // Para PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Solo post por admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol_id'] == 1) {
    
    $nombre = trim($_POST['nombre_completo']);
    $correo = trim($_POST['correo']);
    $password_raw = $_POST['password'];
    $rol = intval($_POST['id_rol']);

    if(empty($nombre) || empty($correo) || empty($password_raw) || $rol === 0){
        $_SESSION['error_crud'] = "Todos los campos son obligatorios.";
        header("Location: ../../views/usuarios/usuarios.php");
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    // Validar que el correo no exista
    $stmtCheck = $db->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo");
    $stmtCheck->bindParam(':correo', $correo);
    $stmtCheck->execute();
    
    if($stmtCheck->rowCount() > 0){
        $_SESSION['error_crud'] = "El correo ingresado ya está registrado.";
        header("Location: ../../views/usuarios/usuarios.php");
        exit();
    }

    // Generar token de verificación
    $token = bin2hex(random_bytes(32));

    // Guardar usuario con verificado=0 y token
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
        
        // Si es cliente (rol 2), crear su registro en clientes
        if($rol == 2){
            $stmtCliente = $db->prepare("INSERT INTO clientes (id_usuario, nombre_completo, telefono, estado) VALUES (:id_usuario, :nombre, '000-0000', 'Activo')");
            $stmtCliente->bindParam(':id_usuario', $id_nuevo_usuario);
            $stmtCliente->bindParam(':nombre', $nombre);
            $stmtCliente->execute();
        }

        // Enviar email de verificación
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP con Mailtrap
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // O tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'TU_USUARIO_SMTP'; // REEMPLAZAR
            $mail->Password = 'TU_PASSWORD_SMTP'; // REEMPLAZAR
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
                Da clic para verificar tu cuenta:<br>
                <a href='$url'>
                Verificar cuenta
                </a><br><br>
                Si no solicitaste esta cuenta, ignora este mensaje.
            ";
            $mail->send();
            $_SESSION['mensaje_crud'] = "Usuario registrado correctamente. Se ha enviado un email de verificación.";
        } catch (Exception $e) {
            $_SESSION['error_crud'] = "Usuario registrado, pero no se pudo enviar el email de verificación: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION['error_crud'] = "Ocurrió un error al registrar el usuario.";
    }

    header("Location: ../../views/usuarios/usuarios.php");
    exit();

} else {
    header("Location: ../../login.php");
    exit();
}
?>
