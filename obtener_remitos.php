<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_constructora";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM remitos WHERE id_remito = $id";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $remito = $result->fetch_assoc();
    echo json_encode($remito);
} else {
    echo json_encode(["error" => "No se encontró el remito."]);
}
?>

