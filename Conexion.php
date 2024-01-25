<?php
// Parámetros de conexión a la base de datos
$host = "localhost"; // o la IP del servidor de bases de datos
$dbname = "tickets";
$username = "root"; // Un usuario diferente de 'root' es recomendado
$password = ""; // La contraseña para ese usuario

// Crear conexión
$conexion = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

// La conexión fue exitosa, no es necesario hacer nada más aquí.
?>
