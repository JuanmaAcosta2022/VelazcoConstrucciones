<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtén el permiso del usuario desde la sesión
$permiso = $_SESSION['permiso'];
?>

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
          <?php if ($permiso == 'administrador'): ?>
            <li class="nav-item"><a class="nav-link" href="admin_usuarios.php">Administrar usuarios</a></li>
            <li class="nav-item"><a class="nav-link" href="backup.php">Backup del sistema</a></li>
            <li class="nav-item"><a class="nav-link" href="restaurar.php">Restaurar sistema</a></li>
          <?php elseif ($permiso == 'usuario encargado'): ?>
            <li class="nav-item"><a class="nav-link" href="gestionstock.php">Gestionar stock</a></li>
            <li class="nav-item"><a class="nav-link" href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
            <li class="nav-item"><a class="nav-link" href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
            <li class="nav-item"><a class="nav-link" href="formulario_auditoria.php">Auditoría de materiales</a></li>
          <?php elseif ($permiso == 'depositero'): ?>
            <li class="nav-item"><a class="nav-link" href="gestionstock.php">Gestionar stock</a></li>
            <li class="nav-item"><a class="nav-link" href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
            <li class="nav-item"><a class="nav-link" href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
            <li class="nav-item"><a class="nav-link" href="formulario_auditoria.php">Auditoría de materiales</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="inicio.php">Ayuda</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>

        </ul>
      </div>
    </div>
  </nav>
</header>

