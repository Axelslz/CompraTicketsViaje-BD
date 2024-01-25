<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registro ConfiguroWeb</h2>
        <form action="loginUser.php" method="post"> <!-- Modificado para enviar a api.php -->
            <div class="form-group">
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control" ?>
                
            </div>    
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" ?>
                
            </div>
            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control">
                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrarse">
            </div>
        </form>
    </div>    
</body>
</html>
