<?php
require_once __DIR__ . '/Api/fpdf/fpdf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre_pasajero = $_POST['nombre_pasajero'] ?? 'Nombre no especificado';
    $ciudad_origen = $_POST['ciudad_origen'] ?? 'Origen no especificado';
    $destino = $_POST['destino'] ?? 'Destino no especificado';
    $tipo_viaje = $_POST['tipo_viaje'] ?? 'Tipo no especificado';
    $fecha = $_POST['fecha'] ?? 'Fecha no especificada';
    $hora = $_POST['hora'] ?? 'Hora no especificada';
    $asiento = $_POST['asiento'] ?? 'Asiento no especificado';
    $precio = $_POST['precio'] ?? 'Precio no especificado';

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(0, 10, "Nombre del Pasajero: $nombre_pasajero", 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Ciudad de Origen: $ciudad_origen", 0, 1);
    $pdf->Cell(0, 10, "Destino: $destino", 0, 1);
    $pdf->Cell(0, 10, "Tipo de Viaje: $tipo_viaje", 0, 1);
    $pdf->Cell(0, 10, "Fecha: $fecha", 0, 1);
    $pdf->Cell(0, 10, "Hora: $hora", 0, 1);
    $pdf->Cell(0, 10, "Asiento: $asiento", 0, 1);
    $pdf->Cell(0, 10, "Precio: $$precio", 0, 1);

    
    $pdf->Output('I', 'ticket.pdf');
} else {
    exit('Error: Este script requiere una solicitud POST.');
}
?>

