<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['nombre_completo'] = 'Test User';
$_POST['correo'] = 'testuser' . time() . '@example.com';
$_POST['password'] = '12345';
$_SERVER['HTTPS'] = 'off';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_NAME'] = '/PROYECTO-FINAL/CRUD-HOTEL-COPIA/php/auth/procesar_registro.php';

try {
    require 'c:/apache/htdocs/PROYECTO-FINAL/CRUD-HOTEL-COPIA/php/auth/procesar_registro.php';
} catch (Throwable $e) {
    echo "CAUGHT EXCEPTION: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
