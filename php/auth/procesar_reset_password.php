<?php
session_start();
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password) || empty($token)) {
        $_SESSION['error_reset'] = "Todos los campos son obligatorios.";
        header("Location: ../../views/reset_password.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error_reset'] = "Las contraseñas no coinciden.";
        header("Location: ../../views/reset_password.php?token=" . urlencode($token));
        exit();
    }

    $database = new Conexion();
    $db = $database->obtenerConexion();

    $stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE token_recuperacion = :token AND expiracion_token_recuperacion > NOW()");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // En este proyecto se guarda la contraseña sin hashear según los datos de prueba ('12345'),
        // Pero idealmente se usaría password_hash. Procederé actualizando igual que la original.
        $stmtUpdate = $db->prepare("UPDATE usuarios SET password = :password, token_recuperacion = NULL, expiracion_token_recuperacion = NULL WHERE token_recuperacion = :token");
        $stmtUpdate->bindParam(':password', $password); // Original plain text style maintained as per DB dump
        $stmtUpdate->bindParam(':token', $token);
        $stmtUpdate->execute();

        $_SESSION['mensaje_login'] = "Tu contraseña ha sido actualizada. Puedes iniciar sesión.";
        header("Location: ../../login.php");
        exit();
    } else {
        $_SESSION['error_reset'] = "El token es inválido o ha expirado.";
        header("Location: ../../views/reset_password.php?token=" . urlencode($token));
        exit();
    }

} else {
    header("Location: ../../login.php");
    exit();
}
?>
