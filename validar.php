<?php
session_start();
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

include('conexion.php');

$consulta = mysqli_query($conexion, "SELECT * FROM administradores WHERE usuario = '$usuario' AND clave = '$clave'");
$fila = mysqli_fetch_assoc($consulta);

if ($fila) {
    $_SESSION['usuario'] = $fila['usuario'];
    $_SESSION['permiso'] = $fila['permiso'];

    // Redirigir según el permiso
    if ($fila['permiso'] == 'administrador') {
        header('Location: admin_dashboard.php'); // Página principal para administrador
    } elseif ($fila['permiso'] == 'usuario encargado') {
        header('Location: encargado_dashboard.php'); // Página principal para usuario encargado
    } elseif ($fila['permiso'] == 'depositero') {
        header('Location: depositero_dashboard.php'); // Página principal para depositero
    }
} else {
    header('Location: login.php?error');
}

mysqli_close($conexion);
?>


