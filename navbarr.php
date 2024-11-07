<!-- archivo: navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="Logo" style="width: 120px;"> <!-- Aumenté el tamaño del logo -->
        </a>

        <!-- Botón para colapsar la barra en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones del menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="gestionstock.php">Gestionar stock</a></li>
                <li class="nav-item"><a class="nav-link" href="remitosdepositero.php">Gestionar y visualizar remitos</a></li>
                <li class="nav-item"><a class="nav-link" href="formulariofechas.php">Consultar stock por intervalos de fechas</a></li>
                <li class="nav-item"><a class="nav-link" href="formulario_auditoria.php">Auditoría de materiales</a></li>
                <li class="nav-item"><a class="nav-link" href="orden_compra.php">Orden de compra</a></li>
                <li class="nav-item"><a class="nav-link" href="inicio.php">Ayuda</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>