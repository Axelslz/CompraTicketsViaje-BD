<?php
// Establecer conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "compratickets");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Manejar solicitud POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Login
    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Validar credenciales
        if(!empty($username) && !empty($password)){
            // Preparar la consulta
            $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
            if($stmt = mysqli_prepare($conexion, $sql)){
                // Vincular variables a la consulta preparada como parámetros
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;

                // Intentar ejecutar la consulta preparada
                if(mysqli_stmt_execute($stmt)){
                    // Guardar resultado
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Vincular variables de resultado
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // La contraseña es correcta, iniciar una nueva sesión
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                                header("location: home.php");
                            } else{
                                $password_err = "La contraseña que has ingresado no es válida.";
                            }
                        }
                    } else{
                        $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                    }
                } else{
                    echo "Algo salió mal, por favor vuelve a intentarlo.";
                }
            }
        }     
    }

    // Registro de usuario
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        // Resto del código de registro...
    
        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
             
            if ($stmt = $conexion->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ss", $param_username, $param_password);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to login page
                    header("location: login.php");
                } else {
                    echo "Algo salió mal, por favor inténtalo de nuevo.";
                }
            }
             
            // Close statement
            $stmt->close();
        }
        
        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Por favor ingresa una contraseña.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "La contraseña al menos debe tener 6 caracteres.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Confirma tu contraseña.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "No coincide la contraseña.";
            }
        }
        
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
             
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    header("loginUser.php");
                } else{
                    echo "Algo salió mal, por favor inténtalo de nuevo.";
                }
            }
             
        }
        
       
    }
}

// Endpoints GET para obtener información variada
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Endpoint para obtener información de vehículos
    if (isset($_GET['endpoint']) && $_GET['endpoint'] === 'vehiculos') {
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
    elseif (isset($_GET['endpoint']) && $_GET['endpoint'] === 'destinos') {
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
    elseif (isset($_GET['endpoint']) && $_GET['endpoint'] === 'pagos') {
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
    elseif (isset($_GET['endpoint']) && $_GET['endpoint'] === 'ordenes') {
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
    elseif (isset($_GET['endpoint']) && $_GET['endpoint'] === 'reporte_destinos') {
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

    // Añade aquí más endpoints si es necesario
}

// Cerrar la conexión al final del script
$conexion->close();
?>