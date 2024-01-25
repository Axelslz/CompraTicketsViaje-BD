<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ 
            font: 14px sans-serif; 
            background: #f7f7f7; /* Color de fondo ligero para mejor contraste */
        }
        .wrapper{ 
            width: 350px; 
            padding: 20px; 
        }
        .center-container {
            height: 100vh; /* Altura completa de la ventana */
            display: flex; /* Uso de Flexbox */
            justify-content: center; /* Centrado horizontal */
            align-items: center; /* Centrado vertical */
        }
    </style>
</head>
<body>
    <div class="center-container">
        <div class="wrapper">
            <h2>Login</h2>
            <form action="home.php" method="post"> <!-- Asegúrate de enviar a api.php -->
                <div class="form-group">
                    <label>Nombre de usuario</label>
                    <input type="text" name="username" class="form-control">
                </div>    
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                </div>
                <p>¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
            </form>
        </div>
    </div>    
</body>
</html>









