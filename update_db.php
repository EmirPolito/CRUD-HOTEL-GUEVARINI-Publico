<?php
require_once 'php/conexion.php';
try {
    $db = (new Conexion())->obtenerConexion();
    try {
        $db->exec("ALTER TABLE usuarios ADD COLUMN token_recuperacion VARCHAR(255) DEFAULT NULL");
        echo "Columna token_recuperacion añadida.\n";
    } catch(Exception $e) { }
    try {
        $db->exec("ALTER TABLE usuarios ADD COLUMN expiracion_token_recuperacion DATETIME DEFAULT NULL");
        echo "Columna expiracion_token_recuperacion añadida.\n";
    } catch(Exception $e) { }
    echo "Proceso terminado.\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
