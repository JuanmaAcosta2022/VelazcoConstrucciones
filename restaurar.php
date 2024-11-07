<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=Debe iniciar sesión para acceder a esta página");
    exit();
}

// Verificar permisos específicos según el archivo
$permiso_requerido = ''; // Define el permiso requerido según el archivo

if (strpos($_SERVER['PHP_SELF'], 'admin_usuarios.php') !== false ||
    strpos($_SERVER['PHP_SELF'], 'backup.php') !== false ||
    strpos($_SERVER['PHP_SELF'], 'restaurar.php') !== false) {
    $permiso_requerido = 'administrador';
} elseif (strpos($_SERVER['PHP_SELF'], 'gestionstock.php') !== false ||
          strpos($_SERVER['PHP_SELF'], 'remitos.php') !== false ||
          strpos($_SERVER['PHP_SELF'], 'formulariofechas.php') !== false ||
          strpos($_SERVER['PHP_SELF'], 'formularioauditoria.php') !== false) {
    $permiso_requerido = 'usuario encargado';
} elseif (strpos($_SERVER['PHP_SELF'], 'remitosdeposito.php') !== false) {
    $permiso_requerido = 'depositero';
}

// Verificar si el usuario tiene el permiso adecuado
if ($_SESSION['permiso'] != $permiso_requerido) {
    header("Location: index.php?error=No tiene permiso para acceder a esta página");
    exit();
}
?>