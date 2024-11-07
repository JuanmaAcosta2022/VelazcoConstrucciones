<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'stock_constructora');

// Verifica si hay error en la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtiene los datos del formulario
$codigo_material = $_POST['codigo_material'];
$cantidad = $_POST['cantidad'];
$persona_solicitante = $_POST['persona_solicitante'];
$deposito = $_POST['deposito'];
$empresa = $_POST['empresa'];
$fecha = date("Y-m-d");

// Inserta la nueva orden de compra en la base de datos
$sql = "INSERT INTO ordenes_compra (codigo_material, cantidad, persona_solicitante, deposito, empresa, fecha) 
        VALUES ('$codigo_material', '$cantidad', '$persona_solicitante', '$deposito', '$empresa', '$fecha')";

if ($conexion->query($sql) === TRUE) {
    echo "Orden de compra creada exitosamente.";
} else {
    echo "Error en la creación de la orden: " . $conexion->error;
}

$conexion->close();
?>

<br>
<a href="index.php">Volver a la lista de órdenes</a>