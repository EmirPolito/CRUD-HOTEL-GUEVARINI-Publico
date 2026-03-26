<?php
require_once 'php/conexion.php';
$database = new Conexion();
$db = $database->obtenerConexion();
$stmt = $db->prepare("UPDATE usuarios SET verificado = 1, token_verificacion = NULL WHERE correo = 'emirpolitog@gmail.com'");
if($stmt->execute()){
    echo "¡Cuenta de emirpolitog@gmail.com verificada con éxito!\n";
} else {
    echo "Hubo un error al verificar la cuenta.\n";
}
?>
