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

$sql_delete = "DELETE FROM remitos WHERE id_remito = $id_remito";

if ($conexion->query($sql_delete) === TRUE) {
    header("Location: remitosdepositero.php?message=Remito eliminado correctamente");
} else {
    echo "<div class='alert alert-danger text-center'>Error al eliminar el remito: " . $conexion->error . "</div>";
}

$conexion->close();
?>
