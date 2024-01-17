<?php
$conexion = new mysqli("localhost", "root", "", "compratickets");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Endpoint para obtener información de vehículos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'vehiculos') {
    $query = "SELECT * FROM vehiculos";
    $resultado = $conexion->query($query);

    $vehiculos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $vehiculos[] = array('vehiculo_id' => $fila['vehiculo_id'], 'capacidad' => $fila['capacidad']);
    }

    header('Content-Type: application/json');
    echo json_encode($vehiculos);
}

