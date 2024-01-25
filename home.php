<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Boletos de Viaje</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
    <h2>Compra tu Ticket de Viaje</h2>
    <form action="generar_ticket.php" method="post">
        <label for="nombre_pasajero">Nombre del Pasajero:</label>
        <input type="text" id="nombre_pasajero" name="nombre_pasajero" required>

        <label for="ciudad_origen">Ciudad de Origen:</label>
        <input type="text" id="ciudad_origen" name="ciudad_origen" required>

        <label for="destino">Destino:</label>
        <input type="text" id="destino" name="destino" required>

        <label for="tipo_viaje">Tipo de Viaje:</label>
        <select id="tipo_viaje" name="tipo_viaje">
            <option value="Autobús">Autobús</option>
            <option value="Tren">Tren</option>
            <option value="Avión">Avión</option>
        </select>
        
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        
        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>

        <label for="asiento">Número de Asiento:</label>
        <input type="text" id="asiento" name="asiento" required>
        
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>
        
        <input type="submit" value="Generar Ticket">
    </form>
</div>

</body>
</html>

