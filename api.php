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

    // Respuesta para el endpoint 'vehiculos'
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

    // Respuesta para el endpoint 'destinos'
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

    // Respuesta para el endpoint 'pagos'
    header('Content-Type: application/json');
    echo json_encode($pagos);
}

// Endpoint para obtener información de las órdenes de compra
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'ordenes') {
    $query = "SELECT ordenes.orden_id, destinos_dia.destino_nombre, pagos.monto, pagos.fecha_pago
              FROM ordenes
              JOIN destinos_dia ON ordenes.destino_id = destinos_dia.destino_id
              JOIN pagos ON ordenes.pago_id = pagos.pago_id";
    
    $resultado = $conexion->query($query);

    $ordenes = array();
    while ($fila = $resultado->fetch_assoc()) {
        $ordenes[] = array(
            'orden_id' => $fila['orden_id'],
            'destino' => $fila['destino_nombre'],
            'monto_pago' => $fila['monto'],
            'fecha_pago' => $fila['fecha_pago']
        );
    }

    // Respuesta para el endpoint 'ordenes'
    header('Content-Type: application/json');
    echo json_encode($ordenes);
}

// Endpoint para generar un reporte de destinos
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'reporte_destinos') {
    $query = "SELECT destinos_dia.destino_nombre, COUNT(ordenes.orden_id) as cantidad_ordenes
              FROM destinos_dia
              LEFT JOIN ordenes ON destinos_dia.destino_id = ordenes.destino_id
              GROUP BY destinos_dia.destino_nombre";
    
    $resultado = $conexion->query($query);

    $reporteDestinos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $reporteDestinos[] = array('destino' => $fila['destino_nombre'], 'cantidad_ordenes' => $fila['cantidad_ordenes']);
    }

    // Respuesta para el endpoint 'reporte_destinos'
    header('Content-Type: application/json');
    echo json_encode($reporteDestinos);
}

// Cerrar la conexión
$conexion->close();
?>

