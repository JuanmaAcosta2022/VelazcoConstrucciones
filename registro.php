<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
</head>
<body style="background-color: #d3d3d3;">
    <div class="login-box">
        <h2>Registrar Usuario</h2>
        <form action="registrar_usuario.php" method="POST">
            <div class="user-box">
                <input type="text" name="usuario" required="">
                <label>Usuario</label>
            </div>
            <div class="user-box">
                <input type="password" name="clave" required="">
                <label>Contraseña</label>
            </div>
            <div class="user-box">
                <label>Permiso</label>
                <select name="permiso" required="" class="form-select">
                    <option value="depositero">Depositero</option>
                    <option value="usuario encargado">Usuario Encargado</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div><br>
            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>
