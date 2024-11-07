<?php
include 'conexion.php';

$fecha = $_POST['fecha'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$codigo = $_POST['codigo'];
$detalle = $_POST['detalle'];
$unidad = $_POST['unidad'];
$cantidad = $_POST['cantidad'];
$observacion = $_POST['observacion'];
$responsable = $_POST['responsable'];

$sql = "INSERT INTO remitos (fecha, origen, destino, codigo_material, detalle, unidad, cantidad, observacion, responsable) VALUES ('$fecha', '$origen', '$destino', '$codigo', '$detalle', '$unidad', '$cantidad', '$observacion', '$responsable')";

if ($conexion->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();
?>


