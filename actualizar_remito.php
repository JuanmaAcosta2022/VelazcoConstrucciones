<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = $_POST['id_remito'];
$fecha = $_POST['fecha'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$codigo = $_POST['codigo_material'];
$detalle = $_POST['detalle'];
$unidad = $_POST['unidad'];
$cantidad = $_POST['cantidad'];
$observacion = $_POST['observacion'];

$sql_update = "UPDATE remitos SET 
    fecha = '$fecha', 
    origen = '$origen', 
    destino = '$destino', 
    codigo_material = '$codigo', 
    detalle = '$detalle', 
    unidad = '$unidad', 
    cantidad = '$cantidad', 
    observacion = '$observacion'
    WHERE id_remito = $id";

if ($conexion->query($sql_update) === TRUE) {
    echo "<script>alert('Remito actualizado correctamente');</script>";
    echo "<script>window.location.href = 'remitosdepositero.php';</script>";
} else {
    echo "Error al actualizar el remito: " . $conexion->error;
}

$conexion->close();
?>



