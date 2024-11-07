<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['permiso'] != 'usuario encargado') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Encargado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
</head>
<body style="background-color: #d3d3d3;">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="logo.jpg" alt="Logo" class="logo" style="height: 40px;">
            </a>
            <!-- Botón para colapsar la barra en dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="gestionstock.php">Gestionar stock</a></li>
                    <li class="nav-item"><a class="nav-link" href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
                    <li class="nav-item"><a class="nav-link" href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
                    <li class="nav-item"><a class="nav-link" href="formulario_auditoria.php">Auditoría de materiales</a></li>
                    <li class="nav-item"><a class="nav-link" href="inicio.php">Ayuda</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        <h1>Bienvenido</h1>
        <!-- Contenido específico para el Usuario Encargado -->
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

