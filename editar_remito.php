<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";
$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id_remito = $_GET['id'];
$query = "SELECT * FROM remitos WHERE id_remito = $id_remito";
$result = $conexion->query($query);

if ($result->num_rows == 1) {
    $remito = $result->fetch_assoc();
} else {
    echo "Remito no encontrado";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $codigo = $_POST['codigo_material'];
    $detalle = $_POST['detalle'];
    $unidad = $_POST['unidad'];
    $cantidad = $_POST['cantidad'];
    $observacion = $_POST['observacion'];

    $sql_update = "UPDATE remitos SET 
                   fecha='$fecha', origen='$origen', destino='$destino', 
                   codigo_material='$codigo', detalle='$detalle', unidad='$unidad', 
                   cantidad='$cantidad', observacion='$observacion' 
                   WHERE id_remito = $id_remito";

    if ($conexion->query($sql_update) === TRUE) {
        echo "<div class='alert alert-success text-center'>Remito actualizado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al actualizar el remito: " . $conexion->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Remito</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Editar Remito</h2>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $remito['fecha']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="origen">Origen</label>
                <input type="text" class="form-control" id="origen" name="origen" value="<?php echo $remito['origen']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="destino">Destino</label>
                <input type="text" class="form-control" id="destino" name="destino" value="<?php echo $remito['destino']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="codigo_material">Código</label>
                <input type="text" class="form-control" id="codigo_material" name="codigo_material" value="<?php echo $remito['codigo_material']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="detalle">Detalle</label>
                <input type="text" class="form-control" id="detalle" name="detalle" value="<?php echo $remito['detalle']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="unidad">Unidad</label>
                <input type="text" class="form-control" id="unidad" name="unidad" value="<?php echo $remito['unidad']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $remito['cantidad']; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <label for="observacion">Observación</label>
                <input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo $remito['observacion']; ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Remito</button>
    </form>
</div>
</body>
</html>

<?php
$conexion->close();
?>