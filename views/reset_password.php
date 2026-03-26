<?php
session_start();
require_once '../php/conexion.php';

if (!isset($_GET['token']) || empty($_GET['token'])) {
    die("Token inválido o no proporcionado.");
}

$token = $_GET['token'];

// Validar que el token existe y no ha expirado
$database = new Conexion();
$db = $database->obtenerConexion();

$stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE token_recuperacion = :token AND expiracion_token_recuperacion > NOW()");
$stmt->bindParam(':token', $token);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("El token es inválido o ha expirado. Por favor, solicita uno nuevo.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña - CRUD HOTEL</title>
    <link rel="stylesheet" href="../css/recuperar-contraseña.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="login-container">
        <h2>Nueva Contraseña</h2>
        
        <?php
        if(isset($_SESSION['error_reset'])){
            echo "<div class='alert alert-error'>" . $_SESSION['error_reset'] . "</div>";
            unset($_SESSION['error_reset']);
        }
        ?>

        <form action="../php/auth/procesar_reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Restablecer Contraseña</button>
        </form>

        <div class="form-links">
            <a href="login.php">Volver al Login</a>
        </div>
    </div>

</body>
</html>
