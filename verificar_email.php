<?php
session_start();
require_once 'php/conexion.php';

if (isset($_GET['token'])) {
    $token = trim($_GET['token']);

    if (empty($token)) {
        // Destruir sesión actual para limpiar
        session_destroy();
        session_start();
        $_SESSION['error_login'] = "Token no proporcionado.";
        header("Location: login.php");
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    // Buscar usuario con el token
    $stmt = $db->prepare("SELECT id_usuario, verificado FROM usuarios WHERE token_verificacion = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario['verificado'] == 0) {
            // Verificar el usuario
            $stmtUpdate = $db->prepare("UPDATE usuarios SET verificado = 1, token_verificacion = NULL WHERE token_verificacion = :token");
            $stmtUpdate->bindParam(':token', $token);
            $stmtUpdate->execute();

            // Destruir sesión actual para limpiar cualquier usuario logueado
            session_destroy();
            session_start();
            $_SESSION['mensaje_login'] = "Email verificado correctamente. Ahora puedes iniciar sesión.";
        } else {
            // El token existe pero ya fue verificado
            session_destroy();
            session_start();
            $_SESSION['mensaje_login'] = "Tu cuenta ya ha sido verificada. Por favor inicia sesión.";
        }
    } else {
        // Token inválido
        session_destroy();
        session_start();
        // No mostrar mensaje de error
    }
} else {
    // Destruir sesión actual para limpiar
    session_destroy();
    session_start();
}

header("Location: login.php");
exit();
?>