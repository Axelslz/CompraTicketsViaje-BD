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

// Endpoint para obtener destinos del día y vehículos asociados
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'destinos') {
    $query = "SELECT destinos_dia.destino_nombre, vehiculos.capacidad 
              FROM destinos_dia
              JOIN vehiculos ON destinos_dia.vehiculo_id = vehiculos.vehiculo_id";
    $resultado = $conexion->query($query);

    $destinos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $destinos[] = array('destino' => $fila['destino_nombre'], 'capacidad' => $fila['capacidad']);
    }

    header('Content-Type: application/json');
    echo json_encode($destinos);
}

// Endpoint para obtener información de pagos
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'pagos') {
    $query = "SELECT * FROM pagos";
    $resultado = $conexion->query($query);

    $pagos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $pagos[] = array('pago_id' => $fila['pago_id'], 'monto' => $fila['monto'], 'fecha_pago' => $fila['fecha_pago']);
    }

    header('Content-Type: application/json');
    echo json_encode($pagos);
}

