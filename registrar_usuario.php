<?php
include('conexion.php');

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$permiso = $_POST['permiso'];

$consulta = "INSERT INTO administradores (usuario, clave, permiso) VALUES ('$usuario', '$clave', '$permiso')";

if (mysqli_query($conexion, $consulta)) {
    header('Location: login.php');
} else {
    echo "Error al registrar usuario: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
